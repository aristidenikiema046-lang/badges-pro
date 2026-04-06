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
            // On vérifie chaque colonne avant de l'ajouter pour éviter l'erreur "Column already exists"
            
            if (!Schema::hasColumn('employees', 'first_name')) {
                $table->string('first_name')->after('id');
            }

            if (!Schema::hasColumn('employees', 'last_name')) {
                $table->string('last_name')->after('first_name');
            }

            if (!Schema::hasColumn('employees', 'department')) {
                // On place department après 'function' (ton champ s'appelle 'function' dans le controller)
                $table->string('department')->nullable()->after('function');
            }

            if (!Schema::hasColumn('employees', 'badge_number')) {
                $table->string('badge_number')->unique()->nullable()->after('department');
            }

            if (!Schema::hasColumn('employees', 'qr_code')) {
                $table->string('qr_code')->nullable()->after('badge_number');
            }

            if (!Schema::hasColumn('employees', 'barcode')) {
                $table->string('barcode')->nullable()->after('qr_code');
            }

            if (!Schema::hasColumn('employees', 'is_validated')) {
                $table->boolean('is_validated')->default(true)->after('barcode');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Liste des colonnes à supprimer en cas de rollback
            $table->dropColumn([
                'first_name', 
                'last_name', 
                'department', 
                'badge_number', 
                'qr_code', 
                'barcode',
                'is_validated'
            ]);
        });
    }
};