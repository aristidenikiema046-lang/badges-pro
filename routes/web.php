<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\BadgeExportController;
use App\Models\Employee;
use App\Models\Company;

// 1. ACCUEIL
Route::get('/', function () { return view('welcome'); })->name('home');

// 2. INSCRIPTION ENTREPRISE (PUBLIQUE / ADMIN)
Route::get('/inscription-partenaire', [CompanyController::class, 'create'])->name('companies.create');
Route::post('/inscription-partenaire', [CompanyController::class, 'store'])->name('companies.store');

// 3. INSCRIPTION EMPLOYÉS (VIA SLUG UNIQUE)
// Utilisation de la méthode du contrôleur pour garder les routes propres
Route::get('/register/{slug}', [EmployeeController::class, 'registerForm'])->name('inscription.tenant');
Route::post('/inscription-employe', [EmployeeController::class, 'store'])->name('employee.store');

// --- ROUTE PUBLIQUE POUR L'APERÇU DU BADGE ---
Route::get('/badge/preview/{id}', [EmployeeController::class, 'preview'])->name('badge.preview');

// 4. EXPORT PDF (Simplifié)
// On ne passe plus le style et le format dans l'URL, le contrôleur les trouvera en BDD
Route::get('/badge/export/{id}', [BadgeExportController::class, 'exportSingle'])->name('badge.export.single');

// 5. ZONE CONNECTÉE (INTERFACE GÉRANT / DASHBOARD)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/employees', [EmployeeController::class, 'index'])->name('company.employees');
    Route::delete('/dashboard/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::patch('/dashboard/employees/{employee}/validate', [EmployeeController::class, 'validate'])->name('employee.validate');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 6. ZONE SUPER-ADMIN (GESTION DES ENTREPRISES)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/entreprises', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('/entreprises/{company}/modifier', [CompanyController::class, 'edit'])->name('companies.edit');
    Route::put('/entreprises/{company}', [CompanyController::class, 'update'])->name('companies.update');
    Route::delete('/entreprises/{company}', [CompanyController::class, 'destroy'])->name('companies.destroy');
    Route::patch('/entreprises/{company}/toggle', [CompanyController::class, 'toggleStatus'])->name('companies.toggle');
});

require __DIR__.'/auth.php';