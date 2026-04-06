<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Affiche le formulaire de création (Vue Orange).
     */
    public function create()
    {
        return view('admin.companies.create');
    }

    /**
     * Enregistre l'entreprise et l'utilisateur, puis redirige vers le dashboard vert.
     */
    public function store(Request $request)
    {
        // 1. Validation des données entrantes
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:companies,email|unique:users,email',
            'manager_name' => 'required|string|max:255',
            'phone'        => 'nullable|string',
            'logo'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 2. Génération du Slug unique pour le lien d'inscription
        $slug = Str::slug($request->name) . '-' . rand(1000, 9999);

        // 3. Gestion du téléchargement du Logo
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        // 4. Création de l'entité Entreprise
        $company = Company::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'manager_name' => $request->manager_name,
            'phone'        => $request->phone,
            'slug'         => $slug,
            'logo'         => $logoPath,
            'is_active'    => true,
        ]);

        // 5. Création du compte Utilisateur lié à l'entreprise
        // Note : Le mot de passe est fixé à 'password123' par défaut ici
        $user = User::create([
            'name'       => $request->manager_name,
            'email'      => $request->email,
            'password'   => Hash::make('password123'), 
            'role'       => 'client',
            'company_id' => $company->id, // Liaison cruciale établie dans le modèle User
        ]);

        // 6. CONNEXION AUTOMATIQUE immédiate de l'utilisateur
        Auth::login($user);

        // 7. REDIRECTION vers le dashboard avec le lien en session
        return redirect()->route('company.employees')->with([
            'success' => "Bienvenue ! Votre compte entreprise a été créé.",
            'generated_link' => url('/register/' . $slug)
        ]);
    }

    /**
     * Liste des entreprises pour le Super-Admin (Vue Noire).
     */
    public function index()
    {
        $companies = Company::all();
        return view('admin.companies.index', compact('companies'));
    }
}