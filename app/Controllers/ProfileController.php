<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ApiClient;

class ProfileController extends BaseController
{
    protected $api;

    public function __construct(ApiClient $api = null)
    {
        $this->api = $api ?? service('apiClient');
    }

    public function index()
    {
        $token = session()->get('token');

        $response = $this->api->get('/profile', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token
            ]
        ]);

        $result = json_decode($response->getBody(), true);

        if ($this->isTokenInvalid($result)) {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Sesi Anda telah habis. Silakan login ulang.');
        }

        $data = $result['data'];
        $data['profile_image'] = $data['profile_image'] ?:  base_url('assets/Profile Photo.png'); // default jika null

        return view('profile/index', [
            'title'   => 'Profil Saya',
            'profile' => $data
        ]);
    }

    public function update()
    {
        $token = session()->get('token');

        $email     = trim($this->request->getPost('email'));
        $firstName = trim($this->request->getPost('first_name'));
        $lastName  = trim($this->request->getPost('last_name'));

        if (!$email || !$firstName || !$lastName) {
            return redirect()->back()->with('error', 'Semua field wajib diisi.')->withInput();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Format email tidak valid.')->withInput();
        }

        $data = [
            'email'      => $email,
            'first_name' => $firstName,
            'last_name'  => $lastName,
        ];

        $response = $this->api->put('/profile/update', $data, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token
            ]
        ]);

        $result = json_decode($response->getBody(), true);

        if ($this->isTokenInvalid($result)) {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Sesi Anda telah habis. Silakan login ulang.');
        }

        if ($result['status'] === 0) {
            return redirect()->to('/profile')->with('success', $result['message'] ?? 'Profil berhasil diperbarui');
        }

        return redirect()->back()->with('error', $result['message'] ?? 'Gagal memperbarui profil')->withInput();
    }

    public function updateImage()
    {
        $token = session()->get('token');
        $file  = $this->request->getFile('profile_image');

        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Gagal mengunggah gambar profil.');
        }

        $stream = fopen($file->getTempName(), 'r');

        $multipart = [
            [
                'name'     => 'profile_image',
                'contents' => $stream,
                'filename' => $file->getName()
            ]
        ];

        $response = $this->api->putMultipart('/profile/image', $multipart, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token
            ]
        ]);

        fclose($stream);

        $result = json_decode($response->getBody(), true);

        if ($this->isTokenInvalid($result)) {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Sesi Anda telah habis. Silakan login ulang.');
        }

        if ($result['status'] === 0) {
            return redirect()->to('/profile')->with('success', 'Foto profil berhasil diperbarui.');
        }

        return redirect()->back()->with('error', $result['message'] ?? 'Gagal mengunggah foto.');
    }

    private function isTokenInvalid($result): bool
    {
        return isset($result['status']) && (int)$result['status'] === 108;
    }
}
