<?php

namespace App\Action;

use Illuminate\Support\Facades\Http;

class HttpRequest 
{
    protected $url;
    
    function __construct($url){
        $this->url = $url;
    }

    protected function run($url){
        $request = Http::get('https://express.api.dhl.com/mydhlapi/test');

        if($request.Status !== 200){
            return $request;
        }else{
            return $request;
        }
    }
}
