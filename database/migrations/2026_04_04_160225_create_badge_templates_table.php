<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('badge_templates', function (Blueprint $table) {
            $table->id();
            // Lien avec l'entreprise (une entreprise peut avoir plusieurs modèles)
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            
            $table->string('name'); // Nom du modèle (ex: "Badge Standard", "Badge Visiteur")
            $table->string('background_image'); // L'image de fond uploadée
            
            // Configuration du design (on stockera ici les positions X et Y des textes)
            $table->json('settings')->nullable(); 
            
            $table->string('format')->default('PVC'); // Format (PVC, A4, etc.)
            $table->boolean('is_default')->default(false); // Modèle par défaut de l'entreprise
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('badge_templates');
    }
};