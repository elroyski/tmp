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
             $table->index('ean'); // Dodaje indeks do kolumny ean
	     $table->index('ilosc_sztuk_s'); // Dodaje indeks do kolumny store_id
	     $table->index('nazwa_indeksu'); // Dodaje indeks do kolumny store_id
	     $table->index('data'); // Dodaje indeks do kolumny store_id



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
