<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\BadgeExportController;
use App\Models\Employee;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

// 1. ACCUEIL
Route::get('/', function () { return view('welcome'); })->name('home');

// 2. INSCRIPTION ENTREPRISE (PUBLIQUE)
Route::get('/inscription-partenaire', [CompanyController::class, 'create'])->name('companies.create');
Route::post('/inscription-partenaire', [CompanyController::class, 'store'])->name('companies.store');

// 3. INSCRIPTION EMPLOYÉS (VIA SLUG)
Route::get('/register/{slug}', function ($slug) {
    $company = Company::where('slug', $slug)->where('is_active', true)->firstOrFail();
    return view('inscription', compact('company'));
})->name('inscription.tenant');

Route::post('/inscription-employe', [EmployeeController::class, 'store'])->name('employee.store');

// --- ROUTE PUBLIQUE POUR LA GÉNÉRATION DU BADGE ---
// Placée ici pour que l'employé puisse voir son badge sans être connecté
Route::get('/badge/preview/{employee}', function (Employee $employee) {
    return view('company.badges.preview_all', compact('employee'));
})->name('badge.preview');

// 4. ZONE CONNECTÉE (DASHBOARD VERT / INTERFACE GÉRANT)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/employees', [EmployeeController::class, 'index'])->name('company.employees');
    Route::delete('/dashboard/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::patch('/dashboard/employees/{employee}/validate', [EmployeeController::class, 'validate'])->name('employee.validate');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// EXPORT (Accessible via lien généré)
Route::get('/badge/export/{id}/{style}/{format}', [BadgeExportController::class, 'exportSingle'])->name('badge.export.single');

// 5. ZONE SUPER-ADMIN (VUE NOIRE)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/entreprises', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('/entreprises/{company}/modifier', [CompanyController::class, 'edit'])->name('companies.edit');
    Route::put('/entreprises/{company}', [CompanyController::class, 'update'])->name('companies.update');
    Route::delete('/entreprises/{company}', [CompanyController::class, 'destroy'])->name('companies.destroy');
    Route::patch('/entreprises/{company}/toggle', [CompanyController::class, 'toggleStatus'])->name('companies.toggle');
});

require __DIR__.'/auth.php';