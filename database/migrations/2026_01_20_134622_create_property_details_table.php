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
        Schema::create('property_details', function (Blueprint $table) {
        $table->id();
        $table->foreignId('property_id')->constrained()->onDelete('cascade');
        $table->longText('description');
        $table->integer('area')->nullable(); // m2
        $table->integer('bedrooms')->default(0);
        $table->integer('bathrooms')->default(0);
        $table->string('country'); 
        $table->string('city');
        $table->string('address');
        $table->string('country_image');
        $table->json('amenities')->nullable(); // On stockera ici [Wifi, Piscine, etc.]
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_details');
    }
};
