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
        Schema::create('primjerak', function (Blueprint $table) {
            $table->id();
            $table->string('inventarniBroj')->unique();
            $table->foreignId('knjiga_id')->constrained('knjiga')->restrictOnDelete();#laravel traži da se id zove *ime tablice*_*na šta se referiramo*,  ograničenje, povezujemo knjiga_id s tablicom knjiga(referencijalni integritet), restrictOnDelete->ako postoji zapis ne može se obrisati
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('primjerak');
    }
};
