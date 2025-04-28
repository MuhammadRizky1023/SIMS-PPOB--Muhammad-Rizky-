<?php

namespace App\Controllers;

use App\Libraries\ApiClient;

class Auth extends BaseController
{
    protected $api;

    public function __construct()
    {
        $this->api = new ApiClient();
    }

    public function login()
    {
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            // Validasi input
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return redirect()->back()->with('error', 'Format email tidak valid!');
            }

            if (strlen($password) < 8) {
                return redirect()->back()->with('error', 'Password minimal 8 karakter!');
            }

            $data = [
                'email' => $email,
                'password' => $password,
            ];

            $response = $this->api->post('/login', $data);
            $result = json_decode($response->getBody(), true);

            if (isset($result['status']) && $result['status'] == 0) {
                session()->set('token', $result['data']['token']);
                return redirect()->to('/dashboard');
            } else {
                return redirect()->back()->with('error', $result['message'] ?? 'Login gagal');
            }
        }

        return view('auth/login');
    }

    public function register()
    {
        if ($this->request->getMethod() === 'post') {
            $firstName = $this->request->getPost('first_name');
            $lastName = $this->request->getPost('last_name');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $confirmPassword = $this->request->getPost('confirm_password');

            // Validasi input
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return redirect()->back()->with('error', 'Format email tidak valid!');
            }

            if (strlen($password) < 8) {
                return redirect()->back()->with('error', 'Password minimal 8 karakter!');
            }

            if ($password !== $confirmPassword) {
                return redirect()->back()->with('error', 'Password dan konfirmasi password tidak cocok!');
            }

            $data = [
                'email'      => $email,
                'first_name' => $firstName,
                'last_name'  => $lastName,
                'password'   => $password,
            ];

            $response = $this->api->post('/registration', $data);
            $result = json_decode($response->getBody(), true);

            if (isset($result['status']) && $result['status'] === 0) {
                return redirect()->to('/login')->with('success', $result['message']);
            } else {
                return redirect()->back()->with('error', $result['message'] ?? 'Registrasi gagal');
            }
        }

        return view('auth/register');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
