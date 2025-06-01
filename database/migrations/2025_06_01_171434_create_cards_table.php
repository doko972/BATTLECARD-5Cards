<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->integer('hp');
            $table->integer('max_hp');
            $table->integer('xp')->default(0); // Ajouter default
            $table->integer('attack');
            $table->integer('defense');
            $table->integer('speed');
            $table->unsignedBigInteger('camp_id');
            $table->string('image_path')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            // Ajouter la contrainte de clé étrangère
            $table->foreign('camp_id')->references('id')->on('camps')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};