<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        // Recherche ajoutée : filtrage par nom ou email
        $query = Company::latest();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        $companies = $query->get();
        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:companies,email|unique:users,email',
            'phone'        => 'nullable|string|max:20',
            'manager_name' => 'nullable|string|max:255',
            'logo'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'badge_style'  => 'required|in:style_1,style_2,style_3,style_4,style_5,style_6',
            'badge_color'  => 'required|string|max:7',
            'password'     => 'required|min:8', 
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos_entreprises', 'public');
            $validated['logo'] = $path;
        }

        $validated['slug'] = Str::slug($request->name) . '-' . Str::lower(Str::random(5));
        $validated['active'] = true;

        // 1. Création de l'entreprise
        $company = Company::create($validated);

        // 2. Création de l'utilisateur associé (GÉRANT D'ENTREPRISE)
        $user = User::create([
            'name'       => $company->name,
            'email'      => $company->email,
            'password'   => Hash::make($request->password),
            'company_id' => $company->id,
            'role'       => 'client', 
        ]);

        // 3. Connexion automatique immédiate
        Auth::login($user);

        // 4. Redirection
        return redirect()->route('company.employees', ['slug' => $company->slug])
            ->with('success', "Bienvenue ! Votre espace {$company->name} a été configuré et vous êtes connecté.");
    }

    public function show($id)
    {
        $company = Company::findOrFail($id);
        return view('admin.companies.show', compact('company'));
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
        
        // Suppression de l'utilisateur associé avant l'entreprise
        if ($company->user) {
            $company->user()->delete();
        }

        if ($company->logo) { 
            Storage::disk('public')->delete($company->logo); 
        }
        
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