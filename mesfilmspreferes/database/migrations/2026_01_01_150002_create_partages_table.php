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
        Schema::create('partages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('favori_id')->constrained('favoris')->onDelete('cascade');
            $table->string('film_title');
            $table->string('film_poster_path')->nullable();
            $table->integer('film_tmdb_id')->nullable();
            $table->foreignId('friend_id')->constrained('users')->onDelete('cascade');
            $table->text('message')->nullable();
            $table->text('avis')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partages');
    }
};

