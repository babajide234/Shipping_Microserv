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
        Schema::create('dhl_domestic_zone_matrices', function (Blueprint $table) {
            $table->id();            
            $table->integer('zone');            
            $table->string('1');            
            $table->string('2');            
            $table->string('3');            
            $table->string('4');            
            $table->string('5');            
            $table->string('6');              
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
        Schema::dropIfExists('dhl_domestic_zone_matrices');
    }
};
