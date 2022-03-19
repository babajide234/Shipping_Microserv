<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use App\Http\Requests\StoreShippingRequest;
use App\Http\Requests\UpdateShippingRequest;
use Illuminate\Support\Facades\Http;
use App\Services\Utilities\HttpRequest;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function fetch()
    {
        $baseUrl = 'https://api.clicknship.com.ng';
        $url = '/clicknship/Operations/States';
        $response = new HttpRequest($url, $baseUrl);
        
        $response = $response->run();

        if(!$response){
            return response()->json(['status' => false, 'message' => 'Server Error'], 500);
        }else{

            if($response->getStatusCode() == 401){
                return response()->json(
                    [
                        'status' => false, 
                        'statusCode' => $response->getStatusCode(),
                        'message' => json_decode($response->getBody())->Message, 
                        'data' =>   json_decode($response->body())
                    ], $response->getStatusCode());
            }

            if($response->getStatusCode() == 200){
                return response()->json(
                    [
                        'status' => true , 
                        'statusCode' => $response->getStatusCode(),
                        'message' => 'Operation Was successful', 
                        'data' => json_decode($response->body())
                    ], $response->getStatusCode());
            }

        }
    }

    public function fetchrates(StoreShippingRequest $request){
       return dd($request);
    }
}
