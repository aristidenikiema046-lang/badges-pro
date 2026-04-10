<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // On vérifie si la colonne n'existe pas déjà par sécurité
            if (!Schema::hasColumn('users', 'company_id')) {
                $table->foreignId('company_id')
                      ->after('password') // On la place après le mot de passe
                      ->nullable()         // Nullable car l'admin n'a pas d'entreprise
                      ->constrained('companies') // Lie à la table companies
                      ->onDelete('cascade');     // Si l'entreprise est supprimée, le user aussi
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });
    }
};