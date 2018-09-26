<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DareenAlterClassName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('DareenTableName', function (Blueprint $table) {
            /* DareenTableDefinition */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('DareenTableName', function (Blueprint $table) {
            /* DareenTableDefinition */
        });
    }
}
