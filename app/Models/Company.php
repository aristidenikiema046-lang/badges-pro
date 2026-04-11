<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne; // <--- AJOUTEZ CECI

class Company extends Model
{
    protected $fillable = [
        'name', 
        'slug', 
        'logo', 
        'address', 
        'email', 
        'phone', 
        'manager_name', 
        'badge_style', 
        'badge_color', 
        'is_active'
    ];

    /**
     * Une entreprise possède un utilisateur gérant (Le propriétaire de l'espace).
     */
    public function user(): HasOne // <--- AJOUTEZ CECI
    {
        return $this->hasOne(User::class);
    }

    /**
     * Une entreprise possède plusieurs employés.
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}