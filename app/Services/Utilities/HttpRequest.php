<?php

namespace App\Services\Utilities;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\BaseServiceInterface;
use App\Models\Token;


class HttpRequest implements BaseServiceInterface
{

    protected String $url;
    protected String $DhlbaseUrl;
    protected String $FedbaseUrl;
    protected Array $data;
    // protected Array $params;
    Protected String $type;

    public function __construct($url,$baseUrl,$data)
    {
        $this->url = $url;
        $this->FedbaseUrl = $baseUrl;
        $this->data = $data;
        // $this->DhlbaseUrl = 'https://express.api.dhl.com/mydhlapi/test';
        // $this->FedbaseUrl = 'https://api.clicknship.com.ng';
        // $this->params = $params;
    }

    public function run()
    {
        $parsedUrl = $this->FedbaseUrl . $this->url;
        $client = new \GuzzleHttp\Client();
        
        // return $this->data;

        try{
            if($this->data){
                $response = Http::withHeaders([
                                    'Content-Type' => 'application/Json'
                                ])->withToken($this->getToken())
                                  ->post($parsedUrl,$this->data);
            }else{
                $response = Http::withHeaders(['Content-Type' => 'application/Json'])
                                ->withToken($this->getToken())->get($parsedUrl);
            }
            return $response;
        }catch(Exeption $e){
            return false;
        }
        
    }  

    public function getToken(){
        return Token::get('access_token')->first()->access_token;
    }
}