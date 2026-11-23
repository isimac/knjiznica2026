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
        Schema::table('posudba', function (Blueprint $table) {
            $table->unsignedSmallInteger('brojDanaKasnjenja')->nullable()->change();
            $table->boolean('zakasninaPlacena')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posudba', function (Blueprint $table) {
            //
        });
    }
};
