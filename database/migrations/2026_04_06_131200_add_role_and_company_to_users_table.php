<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * * Ajoute les colonnes nécessaires pour la gestion des rôles
     * et l'affiliation à une entreprise.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Définit le rôle : 'admin' pour toi, 'client' pour les entreprises
            $table->string('role')->default('client')->after('password'); 

            // Lie l'utilisateur à une entreprise précise
            // Si l'entreprise est supprimée, l'utilisateur l'est aussi (onDelete cascade)
            $table->foreignId('company_id')
                  ->after('role')
                  ->nullable()
                  ->constrained('companies')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // On supprime la clé étrangère d'abord, puis les colonnes
            $table->dropForeign(['company_id']);
            $table->dropColumn(['role', 'company_id']);
        });
    }
};