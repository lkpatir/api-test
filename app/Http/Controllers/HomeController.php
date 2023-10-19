<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\APIService;

class HomeController extends Controller
{
    public function home()
    {
        $data = [
            'page' => "This is the home page"
        ];

        $message = "You found me!";

        return $this->sendResponse($data, $message);
    }

    public function getUsers(APIService $apiService){

        $primary_api_url = env('PRIMARY_API_URL', 'https://randomuser.me/api');
        $fallback_api_url = env('FALLBACK_API_URL', 'https://www.boredapi.com/api/activity');

        //get 3 users
        $response = $apiService->getData(3, $primary_api_url, $fallback_api_url);

        dd($response);
    }
}