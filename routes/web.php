<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\BadgeExportController;

// 1. ACCUEIL
Route::get('/', function () { return view('welcome'); })->name('home');

// 2. CONFIGURATION ENTREPRISE (ADMIN)
Route::get('/inscription-partenaire', [CompanyController::class, 'create'])->name('companies.create');
Route::post('/inscription-partenaire', [CompanyController::class, 'store'])->name('companies.store');

// 3. INSCRIPTION EMPLOYÉS (L'URL que l'employé utilise)
// Cette route AFFICHE le formulaire (GET)
Route::get('/register/{slug}', [EmployeeController::class, 'registerForm'])->name('inscription.tenant');

// Cette route TRAITE le formulaire (POST)
Route::post('/register/save', [EmployeeController::class, 'store'])->name('employee.store');

// 4. APERÇU ET EXPORT DU BADGE
Route::get('/badge/preview/{id}', [EmployeeController::class, 'preview'])->name('badge.preview');
Route::get('/badge/export/{id}', [BadgeExportController::class, 'exportSingle'])->name('badge.export.single');

// 5. ZONE CONNECTÉE (GÉRANT)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/employees', [EmployeeController::class, 'index'])->name('company.employees');
    Route::delete('/dashboard/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 6. ZONE SUPER-ADMIN
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/entreprises', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('/entreprises/{company}/modifier', [CompanyController::class, 'edit'])->name('companies.edit');
    Route::put('/entreprises/{company}', [CompanyController::class, 'update'])->name('companies.update');
    Route::delete('/entreprises/{company}', [CompanyController::class, 'destroy'])->name('companies.destroy');
    Route::patch('/entreprises/{company}/toggle', [CompanyController::class, 'toggleStatus'])->name('companies.toggle');
});

require __DIR__.'/auth.php';