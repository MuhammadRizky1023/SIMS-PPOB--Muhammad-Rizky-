<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Transaction extends BaseController
{
    public function topup()
{
    if ($this->request->getMethod() === 'post') {
        $amount = (int) $this->request->getPost('top_up_amount');

        // Validasi amount minimal dan maksimal
        if ($amount < 10000 || $amount > 1000000) {
            return redirect()->back()->with('error', 'Jumlah top up harus antara Rp10.000 dan Rp1.000.000.');
        }

        $headers = [
            'Authorization' => 'Bearer ' . session()->get('token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $body = json_encode([
            'top_up_amount' => $amount
        ]);

        $response = $this->api->post('/topup', $body, $headers);
        $result = json_decode($response->getBody(), true);

        if ($response->getStatusCode() == 401) {
            return redirect()->to('/login')->with('error', 'Token tidak valid atau kadaluwarsa');
        }

        if ($response->getStatusCode() == 400) {
            return redirect()->back()->with('error', $result['message'] ?? 'Format amount salah');
        }

        if (isset($result['status']) && $result['status'] == 0) {
            // Jika topup sukses, update session balance (ambil ulang dari API)
            $balanceResponse = $this->api->get('/balance', [
                'Authorization' => 'Bearer ' . session()->get('token')
            ]);
            $balanceResult = json_decode($balanceResponse->getBody(), true);

            if (isset($balanceResult['status']) && $balanceResult['status'] == 0) {
                session()->set('balance', $balanceResult['data']['balance']);
            }

            // Set flashdata sukses
            session()->setFlashdata('topup_success', $result['message']);
            return redirect()->to('/dashboard');
        } else {
            // Set flashdata gagal
            session()->setFlashdata('topup_failed', $result['message'] ?? 'Top up gagal');
            return redirect()->back();
        }
    }

    // Ini untuk GET request (tampilkan halaman form Top Up)
    $token = session()->get('token');
    $headers = ['Authorization' => 'Bearer ' . $token];

    // Fetch profile
    $profileResponse = $this->api->get('/profile', $headers);
    $profileResult = json_decode($profileResponse->getBody(), true);

    // Fetch balance
    $balanceResponse = $this->api->get('/balance', $headers);
    $balanceResult = json_decode($balanceResponse->getBody(), true);

    if (($profileResult['status'] ?? 1) !== 0 || ($balanceResult['status'] ?? 1) !== 0) {
        return redirect()->to('/')->with('error', 'Gagal mengambil data.');
    }

    $data = [
        'profile' => $profileResult['data'],
        'balance' => $balanceResult['data']['balance'],
    ];

    return view('transaction/topup', $data);
}

public function payTransaction()
{
    if ($this->request->getMethod() === 'post') {
        $serviceCode = $this->request->getPost('service_code');

        if (empty($serviceCode)) {
            session()->setFlashdata('pay_failed', 'Kode layanan harus diisi.');
            return redirect()->back();
        }

        $headers = [
            'Authorization' => 'Bearer ' . session()->get('token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $body = json_encode([
            'service_code' => $serviceCode
        ]);

        $response = $this->api->post('/transaction', $body, $headers);
        $result = json_decode($response->getBody(), true);

        if ($response->getStatusCode() == 401) {
            session()->setFlashdata('pay_failed', 'Token tidak valid atau kadaluwarsa.');
            return redirect()->to('/login');
        }

        if ($response->getStatusCode() == 400) {
            session()->setFlashdata('pay_failed', $result['message'] ?? 'Layanan tidak ditemukan.');
            return redirect()->back();
        }

        if (isset($result['status']) && $result['status'] == 0) {
            session()->setFlashdata('pay_success', $result['message'] ?? 'Pembayaran berhasil.');
            return redirect()->to('/transaction/history');
        } else {
            session()->setFlashdata('pay_failed', $result['message'] ?? 'Transaksi gagal.');
            return redirect()->back();
        }
    }

    // Ini bagian untuk GET request (buka halaman pembayaran)
    $token = session()->get('token');
    $headers = [
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ];

    // Fetch data profile
    $profileResponse = $this->api->get('/profile', $headers);
    $profileResult = json_decode($profileResponse->getBody(), true);

    // Fetch data balance
    $balanceResponse = $this->api->get('/balance', $headers);
    $balanceResult = json_decode($balanceResponse->getBody(), true);

    if (($profileResult['status'] ?? 1) !== 0 || ($balanceResult['status'] ?? 1) !== 0) {
        return redirect()->to('/')->with('error', 'Gagal mengambil data profile atau saldo.');
    }

    // Ini data service yang dipilih harusnya diambil juga 
    // (bisa lewat session / query param / pilihan user), ini contoh dummy
    $service = [
        'service_name' => 'Contoh Layanan',
        'service_icon' => '/assets/icons/example-icon.png',
        'service_code' => '',
        'service_tariff' => 0,
    ];

    $data = [
        'profile' => $profileResult['data'],
        'balance' => $balanceResult['data']['balance'],
        'service' => $service,
    ];

    return view('transaction/pay', $data);
}


public function history()
{
    $offset = $this->request->getGet('offset') ?? 0;
    $limit = $this->request->getGet('limit') ?? null;

    $headers = [
        'Authorization' => 'Bearer ' . session()->get('token'),
        'Accept' => 'application/json',
    ];

    $queryParams = [];
    if (!is_null($limit)) {
        $queryParams['offset'] = $offset;
        $queryParams['limit'] = $limit;
    }

    $response = $this->api->get('/transaction/history', $headers, $queryParams);
    $result = json_decode($response->getBody(), true);

    if ($response->getStatusCode() == 401) {
        return redirect()->to('/login')->with('error', 'Token tidak valid atau kadaluwarsa');
    }

    if (isset($result['status']) && $result['status'] == 0) {
        return view('transaction/history', [
            'records' => $result['data']['records'],
            'offset' => $result['data']['offset'],
            'limit' => $result['data']['limit'],
        ]);
    } else {
        return view('transaction/history', [
            'records' => [],
            'offset' => 0,
            'limit' => 0,
            'error' => $result['message'] ?? 'Gagal mengambil history transaksi'
        ]);
    }
}
}
