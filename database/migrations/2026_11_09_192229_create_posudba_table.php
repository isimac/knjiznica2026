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
            $table->date('datumPosudbe');#ali je u formatu yyyy-mm-dd
            $table->date('datumPovrata');
            $table->unsignedSmallInteger('brojDanaKasnjenja');
            $table->boolean('zakasninaPlacena');#biti će 0 ili 1, mysql ga tretira kao tinyint(1)
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
