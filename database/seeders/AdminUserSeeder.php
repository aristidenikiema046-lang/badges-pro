<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Administrateur Principal',
            'email' => 'admin@ya-consulting.com', // Ton mail admin
            'password' => Hash::make('bonjour20'), // Ton mot de passe
            'role' => 'admin', // Très important pour le middleware 'admin'
        ]);
    }
}