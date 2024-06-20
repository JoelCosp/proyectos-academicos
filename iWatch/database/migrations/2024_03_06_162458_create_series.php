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
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('synopsis');
            $table->string('director');
            $table->integer('punctuation')->nullable();
            $table->integer('episodes');
            $table->time('duration');
            $table->integer('seasons');
            $table->string('video')->nullable();
            $table->string('poster')->nullable();
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->foreign('categoria_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('sala_id')->nullable();
            $table->foreign('sala_id')->references('id')->on('rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
