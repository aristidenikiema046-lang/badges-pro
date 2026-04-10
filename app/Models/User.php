<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Database\Factories\UserFactory;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Les attributs assignables en masse.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'company_id',
    ];

    /**
     * Les attributs cachés pour la sérialisation.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs à transformer (Casting).
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * RELATION : Un utilisateur peut appartenir à une entreprise (ex: un gérant).
     */
    public function company(): BelongsTo
    {
        // On précise bien la classe Company
        return $this->belongsTo(Company::class);
    }

    /**
     * HELPER : Vérifie si l'utilisateur est un administrateur système.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * HELPER : Vérifie si l'utilisateur est une entreprise cliente (gérant).
     */
    public function isClient(): bool
    {
        return $this->role === 'client';
    }
}