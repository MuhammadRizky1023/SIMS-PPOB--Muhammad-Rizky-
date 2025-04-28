<?php

namespace App\Controllers;

use App\Libraries\ApiClient;

class Dashboard extends BaseController
{
    public function index()
    {
        $api = new ApiClient();

        $token = session()->get('token');

  
        if (!$token) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu.');
        }

     
        $headers = [
            'Authorization' => 'Bearer ' . $token,
        ];

        $profileResponse = $api->get('/profile', $headers);
        $profileResult = json_decode($profileResponse->getBody(), true);

        
        $balanceResponse = $api->get('/balance', $headers);
        $balanceResult = json_decode($balanceResponse->getBody(), true);


        $servicesResponse = $api->get('/services', $headers);
        $servicesResult = json_decode($servicesResponse->getBody(), true);

        $bannersResponse = $api->get('/banner');
        $bannersResult = json_decode($bannersResponse->getBody(), true);

     
        if (
            ($profileResult['status'] ?? 1) !== 0 ||
            ($balanceResult['status'] ?? 1) !== 0 ||
            ($servicesResult['status'] ?? 1) !== 0 ||
            ($bannersResult['status'] ?? 1) !== 0
        ) {
            return redirect()->back()->with('error', 'Gagal mengambil data dari server.');
        }

        return view('dashboard', [
            'profile' => $profileResult['data'] ?? [],
            'balance' => $balanceResult['data']['balance'] ?? 0,
            'services' => $servicesResult['data'] ?? [],
            'banners' => $bannersResult['data'] ?? [],
        ]);
    }
}
