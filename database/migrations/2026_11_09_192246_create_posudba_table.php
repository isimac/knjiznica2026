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
            $table->foreignId('clan_id')->constrained('clan')->restrictOnDelete();
            $table->foreignId('primjerak_id')->constrained('primjerak')->restrictOnDelete();
            $table->date('datumPosudbe');
            $table->date('datumPovrata');
            $table->unsignedSmallInteger('brojDanaKanjenja');
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
