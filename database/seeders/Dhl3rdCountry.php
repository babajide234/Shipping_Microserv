<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use JeroenZwart\CsvSeeder\CsvSeeder;
use App\Models\third_country;

class Dhl3rdCountry extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        third_country::truncate();
        
        $csvFile = fopen(public_path("data/3rd_country.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                third_country::create([
                    "service_area"=> $data['0'],
                    "zone"=> $data['1'],
                    "iso"=> $data['2'],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
