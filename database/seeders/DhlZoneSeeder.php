<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\dhl_zone_price;
use JeroenZwart\CsvSeeder\CsvSeeder;

class DhlZoneSeeder extends Seeder
{
   
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        dhl_zone_price::truncate();
        $csvFile = fopen(public_path("data/dhl_price_zone_import.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                dhl_zone_price::create([
                    "Kg" => $data['0'],
                    "Zone_1"=>$data['1'],
                    "Zone_2"=>$data['2'],
                    "Zone_3"=>$data['3'],
                    "Zone_4"=>$data['4'],
                    "Zone_5"=>$data['5'],
                    "Zone_6"=>$data['6'],
                    "Zone_7"=>$data['7'],
                    "Zone_8"=>$data['8']
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
