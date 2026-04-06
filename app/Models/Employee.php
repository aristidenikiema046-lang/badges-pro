<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    protected $fillable = [
        // Identité de base
        'first_name', 
        'last_name', 
        'gender', 
        'birth_date', 
        'birth_place', 
        'nationality', 
        'photo', 
        'email', 
        'phone',

        // Informations Professionnelles
        'company_id', 
        'matricule', 
        'badge_color', 
        'badge_style', // <-- Nouveau champ ajouté ici
        'function',      
        'department', 
        'level_class', 
        'status', 
        'previous_class', 
        'language_2', 
        'artistic_option',

        // Gestion des Badges
        'badge_number',  
        'qr_code',       
        'barcode',       
        'expiration_date', 
        'is_validated'   
    ];

    /**
     * Un employé appartient à une entreprise.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    
    /**
     * Casts pour transformer les types automatiquement
     */
    protected $casts = [
        'is_validated' => 'boolean',
        'birth_date' => 'date',
        'expiration_date' => 'date',
    ];
}