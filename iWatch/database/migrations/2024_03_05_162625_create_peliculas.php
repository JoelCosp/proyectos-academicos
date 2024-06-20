<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('synopsis');
            $table->string('director');
            $table->time('duration');
            $table->string('episodes');
            $table->string('seasons');
            $table->string('type');
            $table->timestamps();
        });

        // Creamos la tabla pivot para la relación muchos a muchos
        Schema::create('category_film', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('film_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');
            $table->date('creation_date');
            $table->timestamps();
        });

        Schema::create('suscripcion_film', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('suscripcion_id');
            $table->unsignedBigInteger('film_id');
            $table->foreign('suscripcion_id')->references('id')->on('suscripcions')->onDelete('cascade');
            $table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_film');
        Schema::dropIfExists('category_film');
        Schema::dropIfExists('films');
    }
};

