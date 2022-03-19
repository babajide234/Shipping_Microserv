<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use JeroenZwart\CsvSeeder\CsvSeeder;
use App\Models\dhl_domestic_zone;


class DhlDomesticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        dhl_domestic_zone::truncate();
        
        $csvFile = fopen(public_path("data/dhl_domestic_zone_price.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                dhl_domestic_zone::create([
                    "kg"=> 
                    $data['0'],
                    "Zone_A"=> $data['1'],
                    "Zone_B"=> $data['2'],
                    "Zone_C"=> $data['3'],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
