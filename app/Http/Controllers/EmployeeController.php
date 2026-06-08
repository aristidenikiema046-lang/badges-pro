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
     * Enregistre un nouvel employé (Support JSON + Base64 anti-blocage serveur)
     */
    public function store(Request $request, $slug)
    {
        $company = Company::where('slug', $slug)->firstOrFail();

        // 1. Validation des champs textuels standard
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:employees,email',
            'matricule'  => 'required|string|unique:employees,matricule',
            'function'   => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
        ]);

        $validated['company_id'] = $company->id;
        $validated['photo'] = null;

        // 2. Traitement et décodage de la photo en Base64
        if ($request->filled('photo_base64')) {
            try {
                $base64String = $request->input('photo_base64');
                
                // Extraction du type mime et de la chaîne de données pure
                if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
                    $data = substr($base64String, strpos($base64String, ',') + 1);
                    $type = strtolower($type[1]); // jpeg, png, jpg

                    if (in_array($type, ['jpeg', 'jpg', 'png'])) {
                        $decodedData = base64_decode($data);
                        
                        if ($decodedData !== false) {
                            $fileName = 'employees/photos/' . uniqid() . '.' . $type;
                            Storage::disk('public')->put($fileName, $decodedData);
                            $validated['photo'] = $fileName;
                        }
                    }
                }
            } catch (\Exception $e) {
                // Sourdine logique
            }
        }

        // 3. Persistance des données en base
        $employee = Employee::create($validated);

        // 4. Réponse JSON intégrant le segment /public exigé par ton arborescence cPanel
        return response()->json([
            'success' => true,
            'redirect' => '/badges-pro/public/badge/preview/' . $employee->id
        ]);
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