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
            // Ajout de la colonne pour stocker le code hexadécimal de la couleur
            $table->string('badge_color')->nullable()->after('photo'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Suppression de la colonne en cas de rollback
            $table->dropColumn('badge_color');
        });
    }
};