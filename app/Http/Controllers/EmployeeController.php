<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Affiche le formulaire d'inscription pour l'employé via le lien de l'entreprise.
     */
    public function registerForm($slug)
    {
        // On récupère l'entreprise par son slug ou on renvoie une erreur 404
        $company = Company::where('slug', $slug)->firstOrFail();
        
        return view('inscription', compact('company'));
    }

    /**
     * Enregistre l'employé et génère son badge selon le style de l'entreprise.
     */
    public function store(Request $request)
    {
        // 1. Validation des données du formulaire
        // Ajout de 'unique' pour l'email et le matricule pour éviter les doublons
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:employees,email',
            'matricule'  => 'required|string|max:255|unique:employees,matricule',
            'function'   => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'company_id' => 'required|exists:companies,id',
        ], [
            'email.unique' => 'Cet email est déjà utilisé pour un badge.',
            'matricule.unique' => 'Ce matricule existe déjà dans notre base.',
        ]);

        // 2. Récupération de l'entreprise
        $company = Company::findOrFail($request->company_id);

        // --- SÉCURITÉ : Vérification des paramètres de badge de l'entreprise ---
        if (empty($company->badge_style) || empty($company->badge_color)) {
            return back()->withErrors([
                'error' => "Désolé, cette entreprise n'a pas encore configuré son modèle de badge. Veuillez contacter l'administrateur."
            ])->withInput();
        }

        // 3. Création de l'employé
        // Note : On ne stocke plus 'photo' car elle a été retirée du formulaire.
        $employee = Employee::create([
            'first_name'   => $validated['first_name'],
            'last_name'    => $validated['last_name'],
            'email'        => $validated['email'],
            'matricule'    => $validated['matricule'],
            'function'     => $validated['function'],
            'department'   => $validated['department'] ?? 'Général',
            'company_id'   => $company->id,
            
            // On peut stocker les styles en cache sur l'employé ou utiliser directement ceux de la compagnie
            'badge_style'  => $company->badge_style, 
            'badge_color'  => $company->badge_color,
            
            'is_validated' => true, 
        ]);

        // 4. Redirection vers l'aperçu du badge
        // Assure-toi que le nom de ta route est bien 'badge.preview' dans web.php
        return redirect()->route('badge.preview', $employee->id)
                         ->with('success', 'Votre badge a été généré avec succès !');
    }

    /**
     * Affiche l'aperçu du badge après inscription.
     */
    public function preview($id)
    {
        // Chargement de l'employé avec sa relation company
        $employee = Employee::with('company')->findOrFail($id);
        
        // On retourne la vue qui contient les designs de badges
        return view('company.badges.preview_all', compact('employee'));
    }

    /**
     * Liste des employés pour l'Espace Administration.
     */
    public function index()
    {
        $employees = Employee::with('company')->orderBy('created_at', 'desc')->get();
        return view('employees.index', compact('employees'));
    }

    /**
     * Suppression d'un employé.
     */
    public function destroy(Employee $employee)
    {
        // Suppression de la photo uniquement si elle existait encore sur d'anciens enregistrements
        if ($employee->photo && Storage::disk('public')->exists($employee->photo)) {
            Storage::disk('public')->delete($employee->photo);
        }
        
        $employee->delete();
        
        return back()->with('success', 'Employé supprimé du système.');
    }
}