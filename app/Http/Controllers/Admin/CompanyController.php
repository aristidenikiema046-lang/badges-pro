<?php

namespace App\Http\Controllers;

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
        return view('companies.index', compact('companies'));
    }

    /**
     * Formulaire de création d'une entreprise.
     */
    public function create()
    {
        return view('companies.create');
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

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos_entreprises', 'public');
        }

        // Génération d'un slug unique pour le lien d'inscription des employés
        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);

        $company = Company::create($validated);

        return redirect()->route('companies.create')
            ->with('success', 'Entreprise créée !')
            ->with('generated_slug', $company->slug)
            ->with('company_name', $company->name);
    }

    /**
     * Formulaire de modification d'une entreprise.
     */
    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('companies.edit', compact('company'));
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
        ]);

        // Gestion du logo (Suppression de l'ancien si un nouveau est envoyé)
        if ($request->hasFile('logo')) {
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logos_entreprises', 'public');
        }

        // Mise à jour des données
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
            ->with('success', 'Entreprise supprimée.');
    }
}