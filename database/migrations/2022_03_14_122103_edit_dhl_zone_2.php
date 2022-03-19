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
        DB::statement('alter table dhl_zone_prices_international modify kg DOUBLE(15,2)');
        DB::statement('alter table dhl_zone_prices_international modify Zone_1 DOUBLE(15,2)');
        DB::statement('alter table dhl_zone_prices_international modify Zone_2 DOUBLE(15,2)');
        DB::statement('alter table dhl_zone_prices_international modify Zone_3 DOUBLE(15,2)');
        DB::statement('alter table dhl_zone_prices_international modify Zone_4 DOUBLE(15,2)');
        DB::statement('alter table dhl_zone_prices_international modify Zone_5 DOUBLE(15,2)');
        DB::statement('alter table dhl_zone_prices_international modify Zone_6 DOUBLE(15,2)');
        DB::statement('alter table dhl_zone_prices_international modify Zone_7 DOUBLE(15,2)');
        DB::statement('alter table dhl_zone_prices_international modify Zone_8 DOUBLE(15,2)');
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
