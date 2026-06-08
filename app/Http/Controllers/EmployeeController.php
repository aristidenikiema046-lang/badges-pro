<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Liste des employés de l'entreprise
     */
    public function index($slug)
    {
        $user = Auth::user();
        $company = Company::where('slug', $slug)->firstOrFail();

        // SÉCURITÉ : Empêcher une entreprise de voir les données d'une autre
        if ($user->role !== 'admin' && $user->company->slug !== $slug) {
            abort(403, "Vous n'avez pas l'autorisation d'accéder à ce dashboard.");
        }

        $employees = Employee::where('company_id', $company->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('company.employees.index', compact('employees', 'company'));
    }

    /**
     * Formulaire de modification d'un collaborateur
     */
    public function edit($slug, $id)
    {
        $user = Auth::user();
        $company = Company::where('slug', $slug)->firstOrFail();
        $employee = Employee::findOrFail($id);

        // SÉCURITÉ : Vérification du propriétaire
        if ($user->role !== 'admin' && $user->company->slug !== $slug) {
            abort(403);
        }

        if ((int)$employee->company_id !== (int)$company->id) {
            abort(403, "L'employé appartient à une autre entreprise.");
        }

        return view('company.employees.edit', compact('employee', 'company'));
    }

    /**
     * Mise à jour des informations
     */
    public function update(Request $request, $slug, $id)
    {
        $user = Auth::user();
        $company = Company::where('slug', $slug)->firstOrFail();
        $employee = Employee::findOrFail($id);

        // SÉCURITÉ
        if ($user->role !== 'admin' && $user->company->slug !== $slug) {
            abort(403);
        }

        if ((int)$employee->company_id !== (int)$company->id) {
            abort(403);
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:employees,email,' . $employee->id,
            'matricule'  => 'required|string|unique:employees,matricule,' . $employee->id,
            'function'   => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'photo'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'matricule'  => $validated['matricule'],
            'function'   => $validated['function'],
            'department' => $validated['department'],
        ];

        if ($request->hasFile('photo')) {
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }
            $data['photo'] = $request->file('photo')->store('employees/photos', 'public');
        }

        $employee->update($data);

        return redirect()->route('company.employees', $slug)
            ->with('success', 'La fiche de l\'employé a été mise à jour.');
    }

    /**
     * Suppression d'un collaborateur
     */
    public function destroy($slug, $id)
    {
        $user = Auth::user();
        $company = Company::where('slug', $slug)->firstOrFail();
        $employee = Employee::findOrFail($id);

        // SÉCURITÉ
        if ($user->role !== 'admin' && $user->company->slug !== $slug) {
            abort(403);
        }

        if ((int)$employee->company_id !== (int)$company->id) {
            abort(403);
        }

        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }
        
        $employee->delete();

        return redirect()->route('company.employees', $slug)
            ->with('success', 'Employé supprimé avec succès.');
    }

    /**
     * Formulaire d'inscription public
     */
    public function registerForm($slug)
    {
        $company = Company::where('slug', $slug)->firstOrFail();
        return view('company.employees.register', compact('company'));
    }

    /**
     * Enregistre un nouvel employé (Support hybride POST/GET suite aux redirections serveur)
     */
    public function store(Request $request, $slug)
    {
        // Si le serveur (LiteSpeed/Cloudflare) a forcé une redirection et transformé le POST en GET,
        // on injecte les paramètres reçus globaux dans l'instance de validation pour éviter le crash.
        if ($request->isMethod('get')) {
            $request->merge($request->all());
        }

        // 1. Récupération sécurisée de l'entreprise via le slug reçu dans l'URL
        $company = Company::where('slug', $slug)->firstOrFail();

        // 2. Validation des données du formulaire (synchronisée sur les contraintes HTML)
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:employees,email',
            'matricule'  => 'required|string|unique:employees,matricule',
            'function'   => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'photo'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 3. Forcer l'ID de l'entreprise récupérée depuis l'URL
        $validated['company_id'] = $company->id;

        // 4. Traitement du téléversement de la photo
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('employees/photos', 'public');
        }

        // 5. Création de l'employé
        $employee = Employee::create($validated);

        // 6. Redirection relative explicite (évite les conflits d'URLs générées par route() en sous-dossier)
        return redirect()->to('/badges-pro/badge/preview/' . $employee->id);
    }

    /**
     * Aperçu du badge
     */
    public function preview($id)
    {
        $employee = Employee::with('company')->findOrFail($id);
        $style = $employee->company->badge_style ?? 'style_1';

        $getPath = function($path) {
            return empty($path) ? 'https://via.placeholder.com/150' : asset('storage/' . $path);
        };
        
        return view('company.badges.styles.' . $style, compact('employee', 'getPath'));
    }
}