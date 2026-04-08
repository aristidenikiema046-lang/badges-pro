<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            // On vérifie si la colonne n'existe pas avant de l'ajouter pour éviter les erreurs
            if (!Schema::hasColumn('companies', 'badge_style')) {
                $table->string('badge_style')->nullable()->after('manager_name');
            }
            if (!Schema::hasColumn('companies', 'badge_color')) {
                $table->string('badge_color')->nullable()->after('badge_style');
            }
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['badge_style', 'badge_color']);
        });
    }
};