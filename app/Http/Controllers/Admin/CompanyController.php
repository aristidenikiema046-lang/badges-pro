<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    /**
     * Liste globale des entreprises (Pour le Super-Admin).
     */
    public function index()
    {
        $companies = Company::latest()->get();
        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Formulaire de création (Public ou Admin).
     */
    public function create()
    {
        return view('admin.companies.create');
    }

    /**
     * Enregistre l'entreprise et redirige vers SON espace de gestion.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:companies,email',
            'phone'        => 'nullable|string|max:20',
            'manager_name' => 'nullable|string|max:255',
            'logo'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'badge_style'  => 'required|in:style_1,style_2,style_3,style_4,style_5,style_6',
            'badge_color'  => 'required|string|max:7',
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos_entreprises', 'public');
            $validated['logo'] = $path;
        }

        // Création du slug unique
        $validated['slug'] = Str::slug($request->name) . '-' . Str::lower(Str::random(5));
        $validated['active'] = true;

        $company = Company::create($validated);

        // REDIRECTION VERS LE DASHBOARD DE L'ENTREPRISE CRÉÉE
        return redirect()->route('company.employees', ['slug' => $company->slug])
            ->with('success', "Bienvenue ! Votre espace {$company->name} a été configuré.");
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('admin.companies.edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:companies,email,' . $id,
            'phone'        => 'nullable|string|max:20',
            'manager_name' => 'nullable|string|max:255',
            'logo'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'badge_style'  => 'required|in:style_1,style_2,style_3,style_4,style_5,style_6',
            'badge_color'  => 'required|string|max:7',
        ]);

        if ($request->hasFile('logo')) {
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $path = $request->file('logo')->store('logos_entreprises', 'public');
            $validated['logo'] = $path;
        }

        $company->update($validated);

        return redirect()->route('companies.index')
            ->with('success', 'Entreprise mise à jour avec succès !');
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        if ($company->logo) { Storage::disk('public')->delete($company->logo); }
        $company->delete();

        return redirect()->route('companies.index')->with('success', 'Suppression effectuée.');
    }

    public function toggleStatus($id)
    {
        $company = Company::findOrFail($id);
        $company->active = !$company->active;
        $company->save();

        return back()->with('success', "Statut mis à jour.");
    }
}