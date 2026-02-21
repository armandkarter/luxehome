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
        Schema::create('properties', function (Blueprint $table) {
        $table->id();
        $table->uuid('uuid')->unique(); // Ajout de l'UUID
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->string('title');
        $table->string('slug')->unique();
        $table->decimal('price', 15, 2);
        $table->string('price_label')->default('total'); // total, par nuit, par mois
        $table->enum('offer_type', ['Vente', 'Location', 'Réservation']);
        $table->enum('status', ['Disponible', 'Vendu', 'Occupé'])->default('Disponible');
        $table->boolean('is_featured')->default(false); // Pour le badge "Coup de coeur"
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
