<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Profile extends BaseController
{
    public function index()
    {
        $headers = ['Authorization' => 'Bearer ' . session()->get('token')];

        $response = $this->api->get('/profile', $headers);
        $result = json_decode($response->getBody(), true);

        if ($response->getStatusCode() == 401) {
            return redirect()->to('/login')->with('error', 'Token tidak valid atau kadaluwarsa');
        }

        if (isset($result['status']) && $result['status'] == 0) {
            $data['profile'] = $result['data'];
            return view('profile/index', $data);
        } else {
            return redirect()->to('/')->with('error', $result['message'] ?? 'Gagal mengambil data profil');
        }
    }

    public function update()
    {
        $headers = [
            'Authorization' => 'Bearer ' . session()->get('token'),
            'Content-Type' => 'application/json'
        ];

        // Perbaikan disini: name digabung
        $name = $this->request->getPost('first_name') . ' ' . $this->request->getPost('last_name');

        $body = json_encode([
            'name' => $name
        ]);

        $response = $this->api->put('/profile/update', $body, $headers);
        $result = json_decode($response->getBody(), true);

        if ($response->getStatusCode() == 401) {
            return redirect()->to('/login')->with('error', 'Token tidak valid atau kadaluwarsa');
        }

        if (isset($result['status']) && $result['status'] == 0) {
            session()->set('profile', $result['data']); // Opsional
            return redirect()->to('/profile')->with('success', $result['message']);
        } else {
            return redirect()->back()->with('error', $result['message'] ?? 'Gagal update profil');
        }
    }

    public function updateImage()
    {
        $image = $this->request->getFile('profile_image');

        if (!$image || !$image->isValid()) {
            return redirect()->back()->with('error', 'File gambar tidak valid');
        }

        $allowedMimeTypes = ['image/jpeg', 'image/png'];
        if (!in_array($image->getMimeType(), $allowedMimeTypes)) {
            return redirect()->back()->with('error', 'Format gambar harus JPG atau PNG');
        }

        $headers = ['Authorization' => 'Bearer ' . session()->get('token')];
        $tempPath = WRITEPATH . 'uploads/' . $image->getRandomName();
        $image->move(WRITEPATH . 'uploads', basename($tempPath));

        $cfile = new \CURLFile($tempPath, $image->getMimeType(), $image->getName());

        $body = [
            'file' => $cfile
        ];

        $response = $this->api->putMultipart('/profile/image', $body, $headers);
        $result = json_decode($response->getBody(), true);

        @unlink($tempPath); // Hapus file temp sesudah upload

        if ($response->getStatusCode() == 401) {
            return redirect()->to('/login')->with('error', 'Token tidak valid atau kadaluwarsa');
        }

        if ($response->getStatusCode() == 400) {
            return redirect()->back()->with('error', 'Format gambar tidak sesuai');
        }

        if (isset($result['status']) && $result['status'] == 0) {
            session()->set('profile_image', $result['data']['profile_image']);
            return redirect()->to('/profile')->with('success', $result['message']);
        } else {
            return redirect()->back()->with('error', $result['message'] ?? 'Gagal upload gambar');
        }
    }
}
