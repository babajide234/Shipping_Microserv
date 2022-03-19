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
        Schema::create('dhl_zone_price_domestics', function (Blueprint $table) {
            $table->id();
            $table->integer('kg');
            $table->decimal('Zone A',10,2);
            $table->decimal('Zone B',10,2);
            $table->decimal('Zone C',10,2);
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
        Schema::dropIfExists('dhl_zone_price_domestics');
    }
};
