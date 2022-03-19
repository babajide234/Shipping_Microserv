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
        Schema::create('dhl_zone_prices_international', function (Blueprint $table) {
            $table->id();
            $table->integer('kg');
            $table->decimal('Zone_1',10,2);
            $table->decimal('Zone_2',10,2);
            $table->decimal('Zone_3',10,2);
            $table->decimal('Zone_4',10,2);
            $table->decimal('Zone_5',10,2);
            $table->decimal('Zone_6',10,2);
            $table->decimal('Zone_7',10,2);
            $table->decimal('Zone_8',10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dhl_zone_prices');
    }
};
