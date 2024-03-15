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
        Schema::table('raporty_empiku', function (Blueprint $table) {
        $table->string('nr_katalogowy')->after('id_indeksu'); // Dodaje nowe pole nr_katalogowy
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('raporty_empiku', function (Blueprint $table) {
            //
        });
    }
};
