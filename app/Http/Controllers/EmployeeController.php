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
        $company = Company::where('slug', $slug)->firstOrFail();
        return view('inscription', compact('company'));
    }

    /**
     * Enregistre l'employé et génère son badge selon le style de l'entreprise.
     */
    public function store(Request $request)
    {
        // 1. Validation : On retire 'photo' (car supprimé du HTML) 
        // et on ajoute 'email' et 'matricule'.
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'matricule'  => 'required|string|max:255',
            'function'   => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'company_id' => 'required|exists:companies,id',
        ]);

        // 2. Récupération de l'entreprise pour hériter du style
        $company = Company::findOrFail($request->company_id);

        // 3. Création de l'employé avec les styles de l'entreprise
        $employee = Employee::create([
            'first_name'   => $validated['first_name'],
            'last_name'    => $validated['last_name'],
            'email'        => $validated['email'],
            'matricule'    => $validated['matricule'],
            'function'     => $validated['function'],
            'department'   => $validated['department'] ?? 'Général',
            'company_id'   => $company->id,
            
            // HERITAGE AUTOMATIQUE : On prend ce que l'admin a configuré
            'badge_style'  => $company->badge_style, 
            'badge_color'  => $company->badge_color,
            
            'is_validated' => true,
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
        $employee = Employee::with('company')->findOrFail($id);
        return view('company.badges.preview_all', compact('employee'));
    }

    /**
     * Liste des employés.
     */
    public function index()
    {
        $employees = Employee::with('company')->orderBy('created_at', 'desc')->get();
        return view('employees.index', compact('employees'));
    }

    /**
     * Suppression.
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