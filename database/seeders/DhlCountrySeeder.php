<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\country_dhl;
use JeroenZwart\CsvSeeder\CsvSeeder;

class DhlCountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        country_dhl::truncate();
        $csvFile = fopen(public_path("data/dhl_country.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                country_dhl::create([
                    "countries"=> $data['0'],
                    "zone"=> $data['1'],
                    "iso"=> $data['2'],
                    "slug"=> strtolower($data['3']),
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
