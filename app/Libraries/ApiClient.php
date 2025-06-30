<?php

namespace App\Libraries;

class ApiClient
{
    protected $client;

    public function __construct()
    {
        $this->client = \Config\Services::curlrequest([
            'baseURI'    => 'https://take-home-test-api.nutech-integrasi.com',
            'httpErrors' => false,
        ]);
    }

    public function get($endpoint, $headers = [])
    {
        return $this->client->get($endpoint, [
            'headers' => $headers,
        ]);
    }

    public function post($endpoint, $data, $headers = [])
    {
        return $this->client->post($endpoint, [
            'form_params' => $data,
            'headers'     => $headers,
        ]);
    }

    public function put($endpoint, $data, $headers = [])
    {
        return $this->client->request('PUT', $endpoint, [
            'form_params' => $data,
            'headers'     => $headers,
        ]);
    }

    public function putMultipart($endpoint, $multipart, $headers = [])
    {
        return $this->client->request('PUT', $endpoint, [
            'multipart' => $multipart,
            'headers'   => $headers,
        ]);
    }
}
