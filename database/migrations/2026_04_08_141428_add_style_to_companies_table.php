<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Ajoute les colonnes de personnalisation visuelle pour les badges de l'entreprise.
     */
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            // On vérifie si la colonne n'existe pas déjà pour éviter les erreurs
            if (!Schema::hasColumn('companies', 'badge_style')) {
                $table->string('badge_style')->default('1')->after('logo');
            }
            
            if (!Schema::hasColumn('companies', 'badge_color')) {
                $table->string('badge_color')->default('#f97316')->after('badge_style');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['badge_style', 'badge_color']);
        });
    }
};