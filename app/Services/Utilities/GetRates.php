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



class GetRates implements BaseServiceInterface{
    

    protected Array $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function run()
    {
        if($this->params['type'] == 'domestic'){
            // $fedex = $this->getFedEx();
            $dhl = $this->getDhlDomestic();
            $fedex = $this->getFedEx()[0]->TotalAmount;
            $gigm = $this->getGigm();
        }

        if($this->params['type'] == 'international'){
            $dhl = $this->getDhl();
            $fedex = 'Not Available';
            $gigm = 'Not Available';
        }
       
        return [
            'status'=> true,
            'data'=> [
                'dhl' => $dhl,
                'fedex' => $fedex,
                'gigm' => $gigm,
            ]
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
        // Get origin country zone params and zone
        $origin = third_country::where('ISO', $this->params['origin'])->first()->Zone;
        $destination = third_country::where('ISO', $this->params['destination'])->first()->Zone;
        $destinationZone = dhl_domestic_zone_matrix::where('zone', $origin )->first()->$destination;
        $table = 'Zone_'.$destinationZone;
        // Get zone price
        $zonePrice = dhl_domestic_zone::where('kg', $this->params['package']['weight'])->first()->$table;
        return $zonePrice;
    }

    public function getFedEx(){

        $baseUrl = 'https://api.clicknship.com.ng';
        $url = '/clicknship/Operations/DeliveryFee';

        $req = [
            "Origin" => "IBADAN",
            "Destination" => "ABUJA",
            "Weight" => "1.5",
            "PickupType" => "1"
        ];
        $response = new HttpRequest($url, $baseUrl,$req);
        
        $response = $response->run();

        if(!$response){
            return response()->json(['status' => false, 'message' => 'Server Error'], 500);
        }else{

            if($response->getStatusCode() == 401){
                return json_decode($response->getBody())->Message;
            }

            if($response->getStatusCode() == 200){
                return  json_decode($response->body());
            }
            // return  $response->getStatusCode();

        }
    }

    public function getGigm(){
        $from = $this->params['from'];
        $to = $this->params['to'];
        $kg = $this->params['package']['weight'];
        
        // get zone 
        $zone = shiping_zone::where('STATION_NAME',$from)->value($to);
        //get zone price
        $table = 'zone_'.$zone;
        $zoneprice = shiping_rate_zone::where('weight', $kg)->value($table);
        //return price
        return $zoneprice;
    }
}