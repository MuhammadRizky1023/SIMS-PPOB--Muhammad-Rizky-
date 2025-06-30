<?php

namespace Tests\App\Controllers;

use CodeIgniter\Test\FeatureTestCase;
use App\Libraries\ApiClient;

class AuthTest extends FeatureTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    
        // ✅ Atur variabel server agar environment seperti real
        $_SERVER['HTTP_HOST']   = 'localhost';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['REQUEST_URI'] = '/register'; // atau '/login' sesuai test
    
        // ✅ Paksa URI agar site_url tidak error
        $request = service('request');
        $uri = new \CodeIgniter\HTTP\URI('http://localhost/register');
        $reflection = new \ReflectionClass($request);
        $property = $reflection->getProperty('uri');
        $property->setAccessible(true);
        $property->setValue($request, $uri);
    
        // ✅ Mock API Response
        $mockResponse = $this->createMock(\CodeIgniter\HTTP\ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'status'  => 1,
            'message' => 'Mocked registration failed',
        ]));
    
        // ✅ Inject ApiClient mock
        $mockApi = $this->createMock(\App\Libraries\ApiClient::class);
        $mockApi->method('post')->willReturn($mockResponse);
        \Config\Services::injectMock('apiClient', $mockApi);
    }
    



    public function testLoginPageLoads()
    {
        $response = $this->get('/login');
        $response->assertOK();
        $response->assertSee('Login'); // pastikan halaman login mengandung kata "Login"
    }

    public function testRegisterPageLoads()
    {
        $response = $this->get('/register');
        $response->assertOK();
        $response->assertSee('Register'); // pastikan halaman register mengandung kata "Register"
    }

    public function testRegisterWithInvalidData()
    {
        // Simulasi langsung Auth controller tanpa jalankan semua kernel
        $controller = new \App\Controllers\Auth();
        $request = service('request');
        $request->setMethod('post');
        $request->setGlobal('post', [
            'first_name'       => '',
            'last_name'        => '',
            'email'            => 'invalid-email',
            'password'         => '123',
            'confirm_password' => '456',
        ]);
        
        $response = $controller->register();

        $this->assertInstanceOf(\CodeIgniter\HTTP\RedirectResponse::class, $response);
    }
}
