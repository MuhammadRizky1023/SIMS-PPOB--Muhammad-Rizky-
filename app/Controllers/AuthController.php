<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ApiClient;

class AuthController extends BaseController
{
    protected $api;

    public function __construct(ApiClient $api = null)
    {
        $this->api = $api ?? service('apiClient');
    }

    public function login()
    {
        if ($this->request->getMethod() === 'get') {
            return view('auth/login');
        }

        $email    = trim($this->request->getPost('email'));
        $password = trim($this->request->getPost('password'));

        if (!$email || !$password) {
            return redirect()->back()->with('error', 'Email dan password wajib diisi!')->withInput();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Format email tidak valid.')->withInput();
        }

        if (strlen($password) < 6) {
            return redirect()->back()->with('error', 'Password minimal 6 karakter!')->withInput();
        }

        $response = $this->api->post('/login', [
            'email'    => $email,
            'password' => $password
        ]);

        $result = json_decode($response->getBody(), true);

        if (isset($result['status']) && $result['status'] === 0) {
            $user = $result['data'];

            session()->set([
                'token' => $user['token'],
                'name'  => $user['first_name'] . ' ' . $user['last_name'],
                'email' => $user['email'],
                'hide_balance' => true
            ]);

            return redirect()->to('/')->with('success', 'Login berhasil!');
        }

        $error = $result['message'] ?? 'Login gagal, silakan coba lagi.';
        return redirect()->back()->with('error', $error)->withInput();
    }

    public function register()
    {
        if ($this->request->getMethod() === 'get') {
            return view('auth/register');
        }

        $firstName = trim($this->request->getPost('first_name'));
        $lastName  = trim($this->request->getPost('last_name'));
        $email     = trim($this->request->getPost('email'));
        $password  = trim($this->request->getPost('password'));
        $confirm   = trim($this->request->getPost('confirm_password'));

        if (!$firstName || !$lastName || !$email || !$password || !$confirm) {
            return redirect()->back()->with('error', 'Semua field wajib diisi!')->withInput();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Format email tidak valid.')->withInput();
        }

        if (strlen($password) < 6) {
            return redirect()->back()->with('error', 'Password minimal 6 karakter!')->withInput();
        }

        if ($password !== $confirm) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak cocok.')->withInput();
        }

        $response = $this->api->post('/registration', [
            'first_name' => $firstName,
            'last_name'  => $lastName,
            'email'      => $email,
            'password'   => $password
        ]);

        $result = json_decode($response->getBody(), true);

        if (isset($result['status']) && $result['status'] === 0) {
            return redirect()->to('/login')->with('success', 'Registrasi berhasil. Silakan login.');
        }

        $error = $result['message'] ?? 'Registrasi gagal. Silakan coba lagi.';
        return redirect()->back()->with('error', $error)->withInput();
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Berhasil logout.');
    }
}

