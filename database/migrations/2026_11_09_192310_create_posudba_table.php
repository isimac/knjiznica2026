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
        Schema::create('posudba', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clan id')->constrained('clan')->restrictOnDelete();
            $table->foreignId('primjerak id')->constrained('primjerak')->restrictOnDelete();
            $table->date('datumPosudbe');
            $table->date('datumPovrata')->nullable();
            $table->unsignedSmallInteger('brojDanaKasnjenja');
            $table->boolean('zakasninaPlacena');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posudba');
    }
};
