<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Affiche la liste des entreprises.
     */
    public function index()
    {
        $companies = Company::orderBy('created_at', 'desc')->get();
        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create()
    {
        return view('admin.companies.create');
    }

    /**
     * Enregistre une nouvelle entreprise avec ses paramètres de badge.
     */
    public function store(Request $request)
    {
        // 1. Validation rigoureuse
        // 'in:style_1,style_2...' assure que l'admin ne choisit pas une valeur fantaisiste
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:companies,email',
            'phone'        => 'nullable|string|max:20',
            'manager_name' => 'nullable|string|max:255',
            'logo'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'badge_style'  => 'required|string|in:style_1,style_2,style_3,style_4,style_5,style_6',
            'badge_color'  => 'required|string|max:7', // Format hexadécimal (#f97316)
        ], [
            'badge_style.required' => 'Veuillez sélectionner un modèle de badge obligatoirement.',
            'badge_color.required' => 'Veuillez choisir une couleur pour les badges.',
        ]);

        // 2. Gestion du logo
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos_entreprises', 'public');
        }

        // 3. Création de l'entreprise avec génération du Slug unique
        $company = Company::create([
            'name'         => $validated['name'],
            'email'        => $validated['email'],
            'phone'        => $validated['phone'],
            'manager_name' => $validated['manager_name'],
            'slug'         => Str::slug($validated['name']) . '-' . rand(1000, 9999),
            'logo'         => $logoPath,
            'badge_style'  => $validated['badge_style'],
            'badge_color'  => $validated['badge_color'],
            'is_active'    => true,
        ]);

        // 4. Retour avec les données pour la vue (affichage du lien généré)
        return back()->with([
            'success'        => 'Entreprise configurée avec succès !',
            'generated_slug' => $company->slug,
            'company_name'   => $company->name
        ]);
    }

    /**
     * Met à jour les informations d'une entreprise existante.
     */
    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:companies,email,' . $company->id,
            'phone'        => 'nullable|string|max:20',
            'manager_name' => 'nullable|string|max:255',
            'logo'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'badge_style'  => 'required|string|in:style_1,style_2,style_3,style_4,style_5,style_6',
            'badge_color'  => 'required|string|max:7',
        ]);

        // Gestion du logo (Suppression de l'ancien si nouveau téléchargé)
        if ($request->hasFile('logo')) {
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logos_entreprises', 'public');
        }

        // Mise à jour du slug si le nom a changé (optionnel mais recommandé)
        if ($company->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . rand(1000, 9999);
        }

        $company->update($validated);

        return redirect()->route('companies.index')->with('success', 'L\'entreprise et son style de badge ont été mis à jour.');
    }

    /**
     * Supprime une entreprise et ses fichiers associés.
     */
    public function destroy(Company $company)
    {
        // Supprimer le logo du stockage physique
        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
        }

        $company->delete();

        return redirect()->route('companies.index')->with('success', 'Entreprise supprimée avec succès.');
    }
}