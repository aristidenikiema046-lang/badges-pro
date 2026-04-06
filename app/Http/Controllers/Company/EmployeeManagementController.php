<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Company;
use Illuminate\Http\Request;

class EmployeeManagementController extends Controller
{
    // Liste des employés d'une entreprise spécifique
    public function index($slug)
    {
        $company = Company::where('slug', $slug)->firstOrFail();
        $employees = $company->employees()->orderBy('created_at', 'desc')->get();
        
        return view('company.employees.index', compact('company', 'employees'));
    }

    // Valider un badge
    public function validateBadge(Employee $employee)
    {
        $employee->update(['is_validated' => true]);
        return back()->with('success', 'Badge validé avec succès !');
    }
}