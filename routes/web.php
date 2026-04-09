<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\BadgeExportController;

// 1. ACCUEIL
Route::get('/', function () { return view('welcome'); })->name('home');

// 2. CONFIGURATION ENTREPRISE (PUBLIC)
Route::get('/inscription-partenaire', [CompanyController::class, 'create'])->name('companies.create');
Route::post('/inscription-partenaire', [CompanyController::class, 'store'])->name('companies.store');

// 3. INSCRIPTION EMPLOYÉS (VIA LIEN DE PARTAGE)
Route::get('/register/{slug}', [EmployeeController::class, 'registerForm'])->name('inscription.tenant');
Route::post('/register/save', [EmployeeController::class, 'store'])->name('employee.store');

// 4. BADGES
Route::get('/badge/preview/{id}', [EmployeeController::class, 'preview'])->name('badge.preview');
Route::get('/badge/export/{id}', [BadgeExportController::class, 'exportSingle'])->name('badge.export.single');

// 5. ZONE CONNECTÉE (ESPACE GESTION)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/employees', [EmployeeController::class, 'index'])->name('company.employees');
    Route::get('/dashboard/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/dashboard/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/dashboard/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
});

// 6. ZONE SUPER-ADMIN (YA CONSULTING)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Liste et Actions principales
    Route::get('/entreprises', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('/entreprises/{id}/modifier', [CompanyController::class, 'edit'])->name('companies.edit');
    Route::put('/entreprises/{id}', [CompanyController::class, 'update'])->name('companies.update');
    Route::delete('/entreprises/{id}', [CompanyController::class, 'destroy'])->name('companies.destroy');
    Route::patch('/entreprises/{id}/toggle', [CompanyController::class, 'toggleStatus'])->name('companies.toggle');

    // Route spécifique pour l'aperçu dynamique du badge dans le formulaire
    Route::get('/preview-style/{style}', function ($style) {
        $getPath = function($path) {
            return empty($path) ? 'https://via.placeholder.com/150' : asset('storage/' . $path);
        };

        $employee = (object)[
            'first_name' => 'Jean',
            'last_name' => 'DUPONT',
            'matricule' => 'EMP-2026-001',
            'function' => 'Directeur Stratégie',
            'department' => 'DIRECTION',
            'email' => 'j.dupont@consulting.com',
            'photo' => null, 
            'company' => (object)[
                'name' => 'ENTREPRISE DÉMO',
                'badge_color' => request('color', '#f97316'),
                'logo' => null
            ]
        ];

        if (!view()->exists('company.badges.styles.' . $style)) {
            return response("Style introuvable.", 404);
        }

        return view('company.badges.styles.' . $style, compact('employee', 'getPath'));
    })->name('admin.style.render');
});

require __DIR__.'/auth.php';