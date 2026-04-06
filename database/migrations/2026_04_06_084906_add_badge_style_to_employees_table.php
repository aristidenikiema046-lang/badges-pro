<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Ajout de la colonne badge_style après badge_color
            // Valeur par défaut 'style_1' pour ne pas casser les anciens enregistrements
            $table->string('badge_style')->default('style_1')->after('badge_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Suppression de la colonne en cas de rollback
            if (Schema::hasColumn('employees', 'badge_style')) {
                $table->dropColumn('badge_style');
            }
        });
    }
};