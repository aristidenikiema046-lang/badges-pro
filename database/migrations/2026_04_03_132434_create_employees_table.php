<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            // Lien avec l'entreprise
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            
            // Identification (Image 2)
            $table->string('matricule')->unique(); //
            $table->string('first_name'); // Prénom
            $table->string('last_name'); // Nom
            $table->string('gender')->nullable(); // Sexe
            $table->date('birth_date')->nullable(); // Date de naissance
            $table->string('birth_place')->nullable(); // Lieu de naissance
            $table->string('nationality')->nullable(); // Nationalité
            
            // Contact & Poste
            $table->string('photo')->nullable(); // Photo d'identité [cite: 37, 55]
            $table->string('function')->nullable(); // Fonction/Poste [cite: 38, 56]
            $table->string('department')->nullable(); // Département/Service [cite: 39, 57]
            $table->string('email')->nullable(); // [cite: 41, 58]
            $table->string('phone')->nullable(); // [cite: 42, 59]
            
            // Scolarité / Spécifique (Image 2)
            $table->string('level_class')->nullable(); // Classe
            $table->string('status')->nullable(); // Statut (Nouveau...)
            $table->string('previous_class')->nullable(); // Classe précédente
            $table->string('language_2')->nullable(); // LV2
            $table->string('artistic_option')->nullable(); // Option artistique
            
            // Gestion du badge
            $table->date('expiration_date')->nullable(); // [cite: 43]
            $table->boolean('is_validated')->default(false); // Validation entreprise [cite: 63]
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};