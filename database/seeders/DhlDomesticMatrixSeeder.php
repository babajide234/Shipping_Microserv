<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\dhl_domestic_zone_matrix;

class DhlDomesticMatrixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
            //
            dhl_domestic_zone_matrix::truncate();
        
            $csvFile = fopen(public_path("data/dhl_matrix.csv"), "r");
            $firstline = true;
            while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
                if (!$firstline) {
                    dhl_domestic_zone_matrix::create([
                        "Zone"=> $data['0'],
                        "1"=> $data['1'],
                        "2"=> $data['2'],
                        "3"=> $data['3'],
                        "4"=> $data['4'],
                        "5"=> $data['5'],
                        "6"=> $data['6'],
                    ]);
                }
                $firstline = false;
            }
    
            fclose($csvFile);

    }
}
