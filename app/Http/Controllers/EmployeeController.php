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
     * Liste des employés de l'entreprise connectée (Dashboard)
     */
    public function index()
    {
        // On récupère uniquement les employés liés à l'entreprise de l'utilisateur actuel
        $employees = Employee::where('company_id', Auth::user()->company_id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('company.employees.index', compact('employees'));
    }

    /**
     * Formulaire de modification d'un collaborateur (Dashboard)
     */
    public function edit(Employee $employee)
    {
        // Sécurité : Vérifier que l'employé appartient bien à l'entreprise du user connecté
        if ($employee->company_id !== Auth::user()->company_id) {
            abort(403, 'Action non autorisée.');
        }

        return view('company.employees.edit', compact('employee'));
    }

    /**
     * Mise à jour des informations en base de données
     */
    public function update(Request $request, Employee $employee)
    {
        // Sécurité
        if ($employee->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'function'   => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'photo'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo pour économiser de l'espace
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }
            $path = $request->file('photo')->store('employees/photos', 'public');
            $employee->photo = $path;
        }

        $employee->first_name = $validated['first_name'];
        $employee->last_name = $validated['last_name'];
        $employee->function = $validated['function'];
        $employee->department = $validated['department'];
        $employee->save();

        return redirect()->route('company.employees')->with('success', 'La fiche de l\'employé a été mise à jour.');
    }

    /**
     * Suppression définitive d'un collaborateur
     */
    public function destroy(Employee $employee)
    {
        if ($employee->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }
        
        $employee->delete();

        return redirect()->route('company.employees')->with('success', 'Employé supprimé avec succès.');
    }

    /**
     * Affiche le formulaire d'inscription public (via le lien généré)
     */
    public function registerForm($slug)
    {
        // On cherche l'entreprise par son slug unique
        $company = Company::where('slug', $slug)->firstOrFail();

        return view('company.employees.register', compact('company'));
    }

    /**
     * Enregistre un nouvel employé (soumission du formulaire public)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:employees,email',
            'matricule'  => 'required|string|unique:employees,matricule',
            'function'   => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'photo'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Traitement de la photo si présente
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('employees/photos', 'public');
        }

        // Création de l'employé
        Employee::create($validated);

        return back()->with('success', 'Votre demande de badge a été envoyée avec succès !');
    }

    /**
     * Preview du badge (Si nécessaire pour votre logique)
     */
    public function preview($id)
    {
        $employee = Employee::with('company')->findOrFail($id);
        
        // On utilise le style de badge défini dans les paramètres de l'entreprise
        $style = $employee->company->badge_style ?? 'style_1';
        
        return view('company.badges.styles.' . $style, compact('employee'));
    }
}