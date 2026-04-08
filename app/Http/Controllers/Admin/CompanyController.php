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
     * Affiche la liste des entreprises.
     */
    public function index()
    {
        $companies = Company::latest()->get();
        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Formulaire de création d'une entreprise.
     */
    public function create()
    {
        return view('admin.companies.create');
    }

    /**
     * Enregistre une nouvelle entreprise.
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

        // Gestion de l'upload du logo
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos_entreprises', 'public');
            $validated['logo'] = $path;
        }

        // Génération d'un slug unique
        $validated['slug'] = Str::slug($request->name) . '-' . Str::lower(Str::random(5));

        $company = Company::create($validated);

        return redirect()->route('companies.create')
            ->with('success', 'Entreprise créée avec succès !')
            ->with('generated_slug', $company->slug)
            ->with('company_name', $company->name);
    }

    /**
     * Formulaire de modification d'une entreprise.
     */
    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('admin.companies.edit', compact('company'));
    }

    /**
     * Mettre à jour l'entreprise dans la base de données.
     */
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
            'active'       => 'nullable|boolean',
        ]);

        if ($request->hasFile('logo')) {
            // Suppression de l'ancien logo s'il existe
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

    /**
     * Supprime une entreprise et son logo.
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);

        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
        }

        $company->delete();

        return redirect()->route('companies.index')
            ->with('success', 'Entreprise supprimée définitivement.');
    }

    /**
     * Active ou désactive une entreprise.
     */
    public function toggleStatus($id)
    {
        $company = Company::findOrFail($id);
        $company->active = !$company->active;
        $company->save();

        $status = $company->active ? 'activée' : 'désactivée';
        return back()->with('success', "L'entreprise a été {$status} avec succès.");
    }
}