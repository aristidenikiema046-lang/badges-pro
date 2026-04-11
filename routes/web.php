<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\BadgeExportController;

// 1. ACCUEIL
Route::get('/', function () { return view('welcome'); })->name('home');

// 2. CONFIGURATION ENTREPRISE (PUBLIC - INSCRIPTION AUTONOME)
Route::get('/inscription-partenaire', [CompanyController::class, 'create'])->name('companies.create');
Route::post('/inscription-partenaire', [CompanyController::class, 'store'])->name('companies.store');

// 3. INSCRIPTION EMPLOYÉS (VIA LIEN DE PARTAGE UNIQUE)
Route::get('/register/{slug}', [EmployeeController::class, 'registerForm'])->name('inscription.tenant');
Route::post('/register/save', [EmployeeController::class, 'store'])->name('employee.store');

// 4. BADGES ET EXPORT
Route::get('/badge/preview/{id}', [EmployeeController::class, 'preview'])->name('badge.preview');
Route::get('/badge/export/{id}', [BadgeExportController::class, 'exportSingle'])->name('badge.export.single');

// Route d'aperçu dynamique pour la configuration
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

    // Passage de la variable mainColor pour assurer la compatibilité avec tes nouveaux styles
    $mainColor = request('color', '#f97316');

    return view('company.badges.styles.' . $style, compact('employee', 'getPath', 'mainColor'));
})->name('style.preview');

// 5. ZONE GESTION ENTREPRISE (SÉCURISÉE PAR AUTHENTIFICATION)
// On ajoute 'auth' pour que l'entreprise connectée accède à ses propres données
Route::middleware(['auth'])->prefix('{slug}/dashboard')->group(function () {
    Route::get('/employees', [EmployeeController::class, 'index'])->name('company.employees');
    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit')->where('id', '[0-9]+');
    Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update')->where('id', '[0-9]+');
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy')->where('id', '[0-9]+');
});

// 6. ZONE SUPER-ADMIN (YA CONSULTING) - SÉCURISÉE
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/entreprises', [CompanyController::class, 'index'])->name('companies.index');
    
    // Ajout de la contrainte where pour sécuriser les IDs
    Route::get('/entreprises/{id}', [CompanyController::class, 'show'])
         ->name('companies.show')->where('id', '[0-9]+');
    
    Route::get('/entreprises/{id}/modifier', [CompanyController::class, 'edit'])
         ->name('companies.edit')->where('id', '[0-9]+');
         
    Route::put('/entreprises/{id}', [CompanyController::class, 'update'])
         ->name('companies.update')->where('id', '[0-9]+');
         
    Route::delete('/entreprises/{id}', [CompanyController::class, 'destroy'])
         ->name('companies.destroy')->where('id', '[0-9]+');
         
    Route::patch('/entreprises/{id}/toggle', [CompanyController::class, 'toggleStatus'])
         ->name('companies.toggle')->where('id', '[0-9]+');
});

require __DIR__.'/auth.php';