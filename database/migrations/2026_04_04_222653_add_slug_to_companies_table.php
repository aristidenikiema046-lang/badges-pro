<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $blueprint) {
            // On ajoute la colonne slug après le nom
            $blueprint->string('slug')->unique()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $blueprint) {
            $blueprint->dropColumn('slug');
        });
    }
};