<?php

namespace App\Controllers;

use App\Libraries\ApiClient;

class HomeController extends BaseController
{
    protected $api;

    public function __construct(ApiClient $api = null)
    {
        $this->api = $api ?? service('apiClient');
    }

    public function index()
    {
        $token = session()->get('token');

        // Ambil layanan (butuh token)
        $services = $this->fetchServices($token);
        if ($services === null) {
            return $this->handleSessionExpired();
        }

        // Ambil banner (tanpa token)
        $banners = $this->fetchBanners();

        return view('home/index', [
            'services' => $services,
            'banners'  => $banners
        ]);
    }

    

    private function fetchServices(string $token): ?array
    {
        $response = $this->api->get('/services', [
            'headers' => ['Authorization' => 'Bearer ' . $token]
        ]);

        $result = json_decode($response->getBody(), true);

        if ($this->isTokenInvalid($result)) {
            return null;
        }

        return $result['data'] ?? [];
    }

    private function fetchBanners(): array
    {
        $response = $this->api->get('/banner');
        $result = json_decode($response->getBody(), true);

        return $result['data'] ?? [];
    }

    public function toggleSaldo()
    {
        if (!session()->has('token')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        $current = session()->get('hide_balance') ?? true;
        session()->set('hide_balance', !$current);
        return redirect()->back();
    }
    

    private function isTokenInvalid(array $response): bool
    {
        return isset($response['status']) && (int)$response['status'] === 108;
    }

    private function handleSessionExpired()
    {
        session()->destroy();
        return redirect()->to('/login')->with('error', 'Sesi Anda telah habis. Silakan login kembali.');
    }
}
