<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndexPoskoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posko', function (Blueprint $table) {
            $table->index(['title']);
            $table->index(['village_id']);
            $table->index(['area_id']);
            $table->index(['latitude']);
            $table->index(['longitude']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posko', function (Blueprint $table) {
            //
        });
    }
}
