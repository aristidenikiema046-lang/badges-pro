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
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'matricule'  => 'required|string|max:255',
            'function'   => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'company_id' => 'required|exists:companies,id',
        ]);

        // 2. Récupération de l'entreprise
        $company = Company::findOrFail($request->company_id);

        // --- SÉCURITÉ ULTIME : Vérification des styles ---
        // Si l'entreprise n'a pas configuré son style ou sa couleur, on bloque l'inscription
        if (empty($company->badge_style) || empty($company->badge_color)) {
            return back()->withErrors([
                'error' => "Désolé, cette entreprise n'a pas encore configuré son modèle de badge. Veuillez contacter l'administrateur."
            ])->withInput();
        }

        // 3. Création de l'employé avec héritage des styles
        $employee = Employee::create([
            'first_name'   => $validated['first_name'],
            'last_name'    => $validated['last_name'],
            'email'        => $validated['email'],
            'matricule'    => $validated['matricule'],
            'function'     => $validated['function'],
            'department'   => $validated['department'] ?? 'Général',
            'company_id'   => $company->id,
            
            // On utilise les styles configurés par l'entreprise
            'badge_style'  => $company->badge_style, 
            'badge_color'  => $company->badge_color,
            
            'is_validated' => true, // Validé par défaut
        ]);

        // 4. Redirection vers l'aperçu du badge
        return redirect()->route('badge.preview', $employee->id)
                         ->with('success', 'Votre badge a été généré avec succès !');
    }

    /**
     * Affiche l'aperçu du badge.
     */
    public function preview($id)
    {
        // Chargement de l'employé avec sa relation company pour le badge
        $employee = Employee::with('company')->findOrFail($id);
        
        return view('company.badges.preview_all', compact('employee'));
    }

    /**
     * Liste des employés (Espace Administration).
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
        // Suppression de la photo si elle existe
        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }
        
        $employee->delete();
        
        return back()->with('success', 'Employé supprimé du système.');
    }
}