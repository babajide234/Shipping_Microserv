<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRatesRequest;
use App\Services\Utilities\GetRates;

class RatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\StoreRatesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRatesRequest $request)
    {
        // return dd($request);
        $response = new GetRates($request->all());
        $response = $response->run();   
        // return $request;
        return $response;
    }



}
