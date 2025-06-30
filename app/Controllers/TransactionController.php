<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ApiClient;

class TransactionController extends BaseController
{
    protected $api;

    public function __construct(ApiClient $api = null)
    {
        $this->api = $api ?? service('apiClient');
    }

    public function topup()
    {
        if ($this->request->getMethod() === 'post') {
            $amount = (int) $this->request->getPost('top_up_amount');

            if ($amount < 10000 || $amount > 1000000) {
                return view('notifikasi/topup/failed', ['nominal' => $amount]);
            }

            $token = session()->get('token');
            $result = $this->postJson('/topup', ['top_up_amount' => $amount], $token);

            if ($this->isTokenInvalid($result)) {
                return $this->handleSessionExpired();
            }

            if ($result['status'] === 0) {
                return view('notifikasi/topup/success', ['nominal' => $amount]);
            }

            return view('notifikasi/topup/failed', [
                'nominal' => $amount,
                'message' => $result['message'] ?? 'Top up gagal'
            ]);
        }

        return view('transaction/topup');
    }

    public function pay()
    {
        $token = session()->get('token');

        if ($this->request->getMethod() === 'get') {
            $code = $this->request->getGet('code');
            $submit = $this->request->getGet('submit');

            if (!$code) {
                return redirect()->to('/')->with('error', 'Kode layanan tidak valid');
            }

            $service = $this->findServiceByCode($token, $code);
            if (!$service) {
                return redirect()->to('/')->with('error', 'Layanan tidak ditemukan');
            }

            if ($submit) {
                $amount = (int) $service['service_tariff'];
                $result = $this->postJson('/transaction', [
                    'service_code' => $code,
                    'amount' => $amount
                ], $token);

                if ($this->isTokenInvalid($result)) {
                    return $this->handleSessionExpired();
                }

                if ($result['status'] === 0) {
                    $data = $result['data'];
                    return view('notification/payment/success', [
                        'service_name' => $data['service_name'],
                        'invoice' => $data['invoice_number'],
                        'amount' => $data['total_amount'],
                        'time' => $data['created_on']
                    ]);
                }

                return view('notification/payment/failed', [
                    'service_name' => $service['service_name'],
                    'amount' => $amount
                ]);
            }

            return view('transaction/pay', ['service' => $service]);
        }

        // POST = konfirmasi
        $code = $this->request->getPost('service_code');
        if (!$code) {
            return redirect()->back()->with('error', 'Input tidak valid');
        }

        $service = $this->findServiceByCode($token, $code);
        if (!$service) {
            return redirect()->to('/')->with('error', 'Layanan tidak ditemukan');
        }

        return view('notification/payment/confirm', [
            'service_code' => $code,
            'service_name' => $service['service_name'],
            'amount' => $service['service_tariff']
        ]);
    }

    public function history()
    {
        $token = session()->get('token');
        $selectedMonth = $this->request->getGet('month') ?? date('F');
        $page = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 5;

        $availableMonths = [
            'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret',
            'April' => 'April', 'May' => 'Mei', 'June' => 'Juni',
            'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September',
            'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'
        ];

        $result = $this->api->get('/transaction/history', [
            'Authorization' => "Bearer $token"
        ]);
        $data = json_decode($result->getBody(), true);

        if ($this->isTokenInvalid($data)) {
            return $this->handleSessionExpired();
        }

        $transactions = $data['data'] ?? [];

        // Filter bulan & urutkan
        $transactions = array_filter($transactions, fn($trx) =>
            date('F', strtotime($trx['created_at'])) === $selectedMonth
        );
        usort($transactions, fn($a, $b) =>
            strtotime($b['created_at']) - strtotime($a['created_at'])
        );

        $offset = ($page - 1) * $perPage;
        $paged = array_slice($transactions, $offset, $perPage);
        $hasMore = count($transactions) > $offset + $perPage;

        return view('transaction/history', [
            'transactions' => $paged,
            'selectedMonth' => $selectedMonth,
            'availableMonths' => $availableMonths,
            'username' => session()->get('name') ?? 'User',
            'balance' => session()->get('balance') ?? 0,
            'isHidden' => session()->get('hide_balance') ?? true,
            'nextPage' => $page + 1,
            'hasMore' => $hasMore
        ]);
    }

    // ========== Helper Functions ==========

    private function isTokenInvalid(array $result): bool
    {
        return isset($result['status']) && $result['status'] === 108;
    }

    private function handleSessionExpired()
    {
        session()->destroy();
        return redirect()->to('/login')->with('error', 'Sesi kamu telah habis');
    }

    private function postJson(string $endpoint, array $data, string $token): array
    {
        $res = $this->api->post($endpoint, $data, ['Authorization' => "Bearer $token"]);
        return json_decode($res->getBody(), true);
    }

    private function findServiceByCode(string $token, string $code): ?array
    {
        $response = $this->api->get('/services', ['Authorization' => "Bearer $token"]);
        $result = json_decode($response->getBody(), true);

        if ($this->isTokenInvalid($result)) {
            $this->handleSessionExpired();
            return null;
        }

        $services = $result['data'] ?? [];
        $match = array_filter($services, fn($s) => $s['service_code'] === $code);
        return reset($match) ?: null;
    }
}

