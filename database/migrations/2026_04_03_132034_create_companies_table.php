<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Cette table permet de gérer les entreprises clientes[cite: 6, 9].
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nom de l'entreprise [cite: 26]
            $table->string('logo')->nullable(); // Logo de l'entreprise [cite: 26]
            $table->string('address')->nullable(); // Adresse [cite: 26]
            $table->string('email')->unique(); // Email de contact [cite: 26]
            $table->string('phone')->nullable(); // Téléphone [cite: 26]
            $table->string('manager_name')->nullable(); // Nom du responsable [cite: 26]
            $table->boolean('is_active')->default(true); // État du compte (Actif/Désactivé) [cite: 25]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};