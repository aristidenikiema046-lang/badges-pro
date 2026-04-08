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
     * URL : /register/{slug}
     */
    public function registerForm($slug)
    {
        // On cherche l'entreprise par son slug unique
        $company = Company::where('slug', $slug)->firstOrFail();

        return view('employee.register', compact('company'));
    }

    /**
     * Enregistre l'employé en héritant du style de badge de l'entreprise.
     */
    public function store(Request $request)
    {
        // 1. Validation des données de l'employé
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'function'   => 'required|string|max:255',
            'photo'      => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'company_id' => 'required|exists:companies,id',
        ]);

        // 2. On récupère l'entreprise pour copier ses réglages de badge
        $company = Company::findOrFail($request->company_id);

        // 3. Gestion de la photo de l'employé
        $photoPath = $request->file('photo')->store('photos_employes', 'public');

        // 4. Création de l'employé avec héritage du design
        $employee = Employee::create([
            'first_name'   => $validated['first_name'],
            'last_name'    => $validated['last_name'],
            'function'     => $validated['function'],
            'photo'        => $photoPath,
            'company_id'   => $company->id,
            
            // LA MAGIE : L'employé hérite des choix de l'admin
            'badge_style'  => $company->badge_style, 
            'badge_color'  => $company->badge_color,
            
            'matricule'    => 'MAT-' . strtoupper(substr($company->name, 0, 2)) . '-' . rand(1000, 9999),
            'is_validated' => true, // Validé par défaut ou passer à false si besoin d'approbation
        ]);

        // 5. Redirection vers la prévisualisation du badge
        return redirect()->route('badge.preview', $employee->id)
                         ->with('success', 'Votre profil a été enregistré avec succès !');
    }

    /**
     * Affiche l'aperçu du badge après inscription.
     */
    public function preview($id)
    {
        $employee = Employee::with('company')->findOrFail($id);
        
        return view('employee.preview', compact('employee'));
    }

    /**
     * Liste des employés (pour l'administration).
     */
    public function index()
    {
        $employees = Employee::with('company')->orderBy('created_at', 'desc')->get();
        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Suppression d'un employé.
     */
    public function destroy(Employee $employee)
    {
        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }
        
        $employee->delete();
        return back()->with('success', 'Employé supprimé.');
    }
}