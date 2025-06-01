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
        Schema::create('game_decks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('card_id');
            $table->string('position'); // lieutenant, sous_fifre_1, sous_fifre_2, sous_fifre_3, sous_fifre_4
            $table->integer('current_hp');
            $table->boolean('is_alive')->default(true);
            $table->timestamps();

            // Contraintes de clés étrangères
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->foreign('player_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('card_id')->references('id')->on('cards')->onDelete('cascade');

            // Index pour optimiser les recherches
            $table->index(['game_id', 'player_id']);
            $table->index(['game_id', 'position']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_decks');
    }
};