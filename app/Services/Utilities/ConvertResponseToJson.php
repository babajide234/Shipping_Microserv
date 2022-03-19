<?php

namespace App\Services\Utilities;

use App\Services\BaseServiceInterface;

class ConvertResponseToJson implements BaseServiceInterface
{
    protected $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    public function run()
    {
        $arrays = explode('&', $this->response);
        $obj = array();
        foreach ($arrays as $array) {
            $child = explode('=', $array);
            $obj[$child[0]] = $child[1];
        }
        return $obj;
    }  
}