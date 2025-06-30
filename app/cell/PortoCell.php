<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class PortoCell extends Cell
{
    public function render()
    {
        $session = session();
        $token = $session->get('token');
        $hidden = $session->get('hide_balance') ?? true;

        $api = service('apiClient');

        // Ambil profil user
        $profileRes = $api->get('/profile', [
            'headers' => ['Authorization' => "Bearer $token"]
        ]);
        $profile = json_decode($profileRes->getBody(), true)['data'] ?? [];

        // Ambil saldo user
        $balanceRes = $api->get('/balance', [
            'headers' => ['Authorization' => "Bearer $token"]
        ]);
        $balance = json_decode($balanceRes->getBody(), true)['data']['balance'] ?? 0;

        // Data ke view
        return view('partials/portofolio', [
            'user' => [
                'name' => trim(($profile['first_name'] ?? '') . ' ' . ($profile['last_name'] ?? '')),
                'email' => $profile['email'] ?? '',
                'profile_image' => $profile['profile_image'] ?: base_url('assets/Profile Photo.png'),
            ],
            'balance' => $balance,
            'hidden' => $hidden,
        ]);
    }
}
