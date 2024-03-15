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
        Schema::create('raporty_empiku', function (Blueprint $table) {
            $table->id();
            $table->date('data'); // data dodania do bazy
	    $table->bigInteger('id_indeksu'); // identyfikator indeksu
	    $table->string('ean'); // EAN
	    $table->string('nazwa_indeksu'); // nazwa indeksu
	    $table->bigInteger('store_id'); // identyfikator sklepu
	    $table->string('site_name'); // nazwa punktu sprzedazy
	    $table->string('status_indeksu'); // status indeksu
	    $table->integer('ilosc_sztuk_s'); // ilość sztuk sprzedanych
	    $table->integer('ilosc_sztuk_z'); // ilość sztuk zapasu
	    $table->string('producent'); // producent
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raporty_empiku');
    }
};
