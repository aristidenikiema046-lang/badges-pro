<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BadgeTemplate extends Model
{
    protected $fillable = ['company_id', 'name', 'background_image', 'settings', 'format', 'is_default'];

    protected $casts = [
        'settings' => 'array', // Transforme automatiquement le JSON en tableau PHP
    ];
}