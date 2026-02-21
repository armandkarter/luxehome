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
        Schema::create('property_inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained();
            $table->string('type_action'); // contact, rent, booking
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('id_card');
            $table->date('visit_date')->nullable();
            $table->string('visit_time')->nullable();
            $table->date('arrival_date')->nullable();
            $table->integer('nights')->nullable(); // correspond à tes "nights"
            $table->text('price')->nullable();
            $table->text('objet')->nullable();
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'complete', 'closed'])->nullable();; 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_inquiries');
    }
};
