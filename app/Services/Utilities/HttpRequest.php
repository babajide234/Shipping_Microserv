<?php

namespace App\Services\Utilities;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\BaseServiceInterface;
use App\Models\Token;


class HttpRequest implements BaseServiceInterface
{

    protected String $url;
    protected String $FedbaseUrl;
    protected Array $data;
    Protected String $type;
    // protected Array $params;
    // protected String $DhlbaseUrl;

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
            $date = Token::all()->pluck('expires_in');
            $date = gmdate("l jS \of F Y h:i:s A", $date[0]);
            // return $date;
            // $date = new DateTime($date);
            // dd($date);
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
    
    public function reAuth(){
        // $client = new \GuzzleHttp\Client();

        $baseUrl = 'https://Api.Clicknship.com.ng/Token';
        $url = $baseUrl.'/Token?username=cnsdemoapiacct&password=ClickNShip$12345&grant_type=password';
        $req = [
            "username" => 'cnsdemoapiacct',
            "password" => 'ClickNShip$12345',
            "grant_type" => 'password'
        ];
        $response = Http::withBody('username=cnsdemoapiacct&password=ClickNShip$12345&grant_type=password','application/x-www-form-urlencoded')->post($baseUrl);
        
        // dd($response->body());
        $data = json_decode($response->body());
        // return $data;
        $token = Token::where('id',2);
        // $token->access_token = $data->access_token;
        // $token->token_type = $data->token_type;
        // $token->expires_in = $data->expires_in;
        $token->update(['access_token' => $data->access_token,'token_type' => $data->token_type, 'expires_in' => $data->expires_in]);
    }
}