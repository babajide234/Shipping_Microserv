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
        Schema::create('dhl_domestic_zones', function (Blueprint $table) {
            $table->id();
            $table->string('kg');
            $table->decimal('Zone_A',10,2);
            $table->decimal('Zone_B',10,2);
            $table->decimal('Zone_C',10,2);
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
        Schema::dropIfExists('dhl_domestic_zones');
    }
};
