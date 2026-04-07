<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Liste des entreprises pour le Super-Admin (Vue Noire).
     */
    public function index()
    {
        $companies = Company::all();
        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Affiche le formulaire de création (Vue Orange).
     */
    public function create()
    {
        return view('admin.companies.create');
    }

    /**
     * Enregistre l'entreprise et l'utilisateur.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:companies,email|unique:users,email',
            'manager_name' => 'required|string|max:255',
            'phone'        => 'nullable|string',
            'logo'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $slug = Str::slug($request->name) . '-' . rand(1000, 9999);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $company = Company::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'manager_name' => $request->manager_name,
            'phone'        => $request->phone,
            'slug'         => $slug,
            'logo'         => $logoPath,
            'is_active'    => true,
        ]);

        User::create([
            'name'       => $request->manager_name,
            'email'      => $request->email,
            'password'   => Hash::make('password123'), 
            'role'       => 'client',
            'company_id' => $company->id,
        ]);

        return redirect()->back()->with([
            'success'        => "L'entreprise {$request->name} a été enregistrée avec succès !",
            'generated_slug' => $slug,
            'company_name'   => $request->name
        ]);
    }

    /**
     * Affiche le formulaire de modification (RÉSOUT TON ERREUR)
     */
    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }

    /**
     * Met à jour les informations de l'entreprise
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:companies,email,' . $company->id,
            'manager_name' => 'required|string|max:255',
        ]);

        $data = $request->only(['name', 'email', 'manager_name', 'phone']);

        if ($request->hasFile('logo')) {
            // Supprimer l'ancien logo s'il existe
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $company->update($data);

        return redirect()->route('companies.index')->with('success', 'Entreprise mise à jour !');
    }

    /**
     * Active ou Désactive l'entreprise (Action des flèches)
     */
    public function toggleStatus(Company $company)
    {
        $company->update([
            'is_active' => !$company->is_active
        ]);

        return redirect()->back()->with('success', 'Statut mis à jour avec succès.');
    }

    /**
     * Supprime une entreprise
     */
    public function destroy(Company $company)
    {
        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
        }
        
        $company->delete();

        return redirect()->route('companies.index')->with('success', 'Entreprise supprimée.');
    }
}