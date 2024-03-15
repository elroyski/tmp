<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToTables extends Migration
{
    public function up()
    {

        Schema::table('books', function (Blueprint $table) {
            $table->index('ean');
        });
    }

    public function down()
    {

        Schema::table('books', function (Blueprint $table) {
            $table->dropIndex(['ean']);
        });
    }
}
