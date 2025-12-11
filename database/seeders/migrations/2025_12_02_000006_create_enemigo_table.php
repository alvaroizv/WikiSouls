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
        Schema::create('enemigo', function (Blueprint $table) {
            $table->id();
            $table->integer('vida_T');
            $table->integer('ataque_T');
            $table->foreignId("zona_id")->constrained('zona')->onDelete('cascade');
            $table->foreignId("arma_id")->constrained('arma')->onDelete('cascade');
            $table->foreignId("escudo_id")->constrained('escudo')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enemigo');
    }
};