<?php


namespace App\Services\Utilities;
use Illuminate\Support\Facades\Log;
use App\Services\BaseServiceInterface;
use App\Services\Utilities\HttpRequest;
use App\Models\country_dhl;
use App\Models\dhl_zone_price;
use App\Models\shiping_zone;
use App\Models\shiping_rate_zone;
use App\Models\third_country;
use App\Models\dhl_domestic_zone_matrix;
use App\Models\dhl_domestic_zone;
use App\Models\Token;



class GetRates implements BaseServiceInterface{
    

    protected Array $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function run()
    {
        if(empty($this->params)){
            return [
                'status'=> false,
                'message'=> 'Empty parameters ',
                'data'=> []
            ];
        }
        // dd($this->getFedEx());
        if($this->params['type'] == 'domestic'){
            $dhl = $this->getDhlDomestic();
            $fedex = $this->getFedEx()[0]->TotalAmount;
            $gigm = $this->getGigm();
        }

        if($this->params['type'] == 'international'){
            $dhl = $this->getDhl();
        }
        
        $data =[];

        if($dhl == null){
            $data = [
                'fedex' => $fedex,
                'gigm' => $gigm,
            ];
        } elseif ($fedex == null) {
            $data = [
                'dhl' => $dhl,
                'gigm' => $gigm,
            ];
        } elseif ($gigm == null) {
            $data = [
                'dhl' => $dhl,
                'fedex' => $fedex,
            ];
        } else{
            $data = [
                'dhl' => $dhl,
                'fedex' => $fedex,
                'gigm' => $gigm,
            ];

        }

        return [
            'status'=> true,
            'data'=> $data
        ];
    }

    public function getDhl()
    {
        // Get origin country zone params and zone
        $zone = country_dhl::where('iso', $this->params['origin'])->first()->zone;
        // Get zone price
        $table = 'Zone_'.$zone;
        $zonePrice = dhl_zone_price::where('kg', $this->params['package']['weight'])->first();
        return $zonePrice[$table];
    }

    public function getDhlDomestic()
    {
        if($this->params['origin'] !== "NG"){
            // Get origin country zone params and zone
            $origin = third_country::where('ISO', $this->params['origin'])->first()->Zone;            
        }else{
            $origin = third_country::where('ISO', $this->params['origin'])->first()->Zone;
        }
        $destination = third_country::where('ISO', $this->params['destination'])->first()->Zone;
        $destinationZone = dhl_domestic_zone_matrix::where('zone', $origin )->first()->$destination;
        $table = 'Zone_'.$destinationZone;
        // Get zone price
        if($this->params['package']['weight'] >= '30'){
            $weight = ceil($this->params['package']['weight'] / 10)*10;
        }else{
            $weight = $this->params['package']['weight'];
        }
        $zonePrice = dhl_domestic_zone::where('kg', $weight)->first()->$table;
        return (float)$zonePrice;
    }

    public function getFedEx(){

        $baseUrl = 'https://api.clicknship.com.ng';
        $url = '/clicknship/Operations/DeliveryFee';
        
        $origin='';
        $destination='';

        if(strtoupper($this->params['to']) === 'LAGOS' ){
        
            $destination = 'LAGOS MAINLAND';
        
        }else{
            
            $destination = strtoupper($this->params['to']);
        
        }

        if(strtoupper($this->params['from']) === 'LAGOS'){
            
            $origin = 'LAGOS MAINLAND';

        }else{

            $origin = strtoupper($this->params['from']);

        }
        $req = [
            "Origin" => $origin ,
            "Destination" => $destination ,
            "Weight" => $this->params['package']['weight'],
            "PickupType" => "1"
        ];
        // return $req;
        $response = new HttpRequest($url, $baseUrl,$req);
        
        $response = $response->run();
        // return json_decode($response->getBody());
        // return $response;
        if(!$response){
            return response()->json(['status' => false, 'message' => 'Server Error'], 500);
        }else{

            if($response->getStatusCode() == 401){
                
                // $response->reAuth();
                $req = [
                    "Origin" => $origin ,
                    "Destination" => $destination ,
                    "Weight" => $this->params['package']['weight'],
                    "PickupType" => "1"
                ];
                $res = new HttpRequest($url, $baseUrl,$req);
                $res->reAuth();
                // return $req;
                $response = new HttpRequest($url, $baseUrl,$req);
                $response = $response->run();
                return  json_decode($response->body());
            }

            if($response->getStatusCode() == 200){
                return  json_decode($response->body());
            }
            // return  $response->getStatusCode();

        }
    }

    public function getGigm(){
        // $origin='';
        // $destination='';

        // if(strtoupper($this->params['from']) ) {
        //     $origin = 'LAGOS ';
        // }
        $from = $this->params['from'];
        $to = $this->params['to'];
        $kg = $this->params['package']['weight'];
        
        // get zone 
        $zone = shiping_zone::where('STATION_NAME',$from)->value($to);
        //get zone price
        $table = 'zone_'.$zone;
        // return $table;
        $zoneprice = shiping_rate_zone::where('weight', $kg)->value($table);
        //return price
        return $zoneprice;
    }



}