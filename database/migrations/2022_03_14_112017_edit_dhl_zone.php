<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('dhl_zone_prices_international', function (Blueprint $table) {
            $table->integer('Zone_1')->change();
            $table->integer('Zone_2')->change();
            $table->integer('Zone_3')->change();
            $table->integer('Zone_4')->change();
            $table->integer('Zone_5')->change();
            $table->integer('Zone_6')->change();
            $table->integer('Zone_7')->change();
            $table->integer('Zone_8')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
