<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'badge_style', // AJOUTÉ
        'badge_color', // AJOUTÉ
        'is_active'
    ];

    /**
     * Une entreprise possède plusieurs employés.
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}