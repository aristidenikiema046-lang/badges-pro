<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Liste des employés de l'entreprise
     */
    public function index($slug)
    {
        $company = Company::where('slug', $slug)->firstOrFail();

        $employees = Employee::where('company_id', $company->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // CORRECTION ICI : Le chemin correspond à ton dossier
        return view('company.employees.index', compact('employees', 'company'));
    }

    /**
     * Formulaire de modification d'un collaborateur
     */
    public function edit($slug, Employee $employee)
    {
        $company = Company::where('slug', $slug)->firstOrFail();

        if ($employee->company_id !== $company->id) {
            abort(403);
        }

        return view('company.employees.edit', compact('employee', 'company'));
    }

    /**
     * Mise à jour des informations
     */
    public function update(Request $request, $slug, Employee $employee)
    {
        $company = Company::where('slug', $slug)->firstOrFail();

        if ($employee->company_id !== $company->id) {
            abort(403);
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'function'   => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'photo'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }
            $path = $request->file('photo')->store('employees/photos', 'public');
            $employee->photo = $path;
        }

        $employee->update([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'function'   => $validated['function'],
            'department' => $validated['department'],
        ]);

        return redirect()->route('company.employees', $slug)
            ->with('success', 'La fiche de l\'employé a été mise à jour.');
    }

    /**
     * Suppression d'un collaborateur
     */
    public function destroy($slug, Employee $employee)
    {
        $company = Company::where('slug', $slug)->firstOrFail();

        if ($employee->company_id !== $company->id) {
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
     * Enregistre un nouvel employé
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

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('employees/photos', 'public');
        }

        Employee::create($validated);

        return back()->with('success', 'Votre demande de badge a été envoyée !');
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