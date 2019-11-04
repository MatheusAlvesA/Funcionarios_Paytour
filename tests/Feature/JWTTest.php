<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JWTTest extends TestCase
{

    public function testGetToken()
    {
        $response = $this->post('api/login', [
			"email" => "matheuseejam@gmail.com",
			"password" => "p4yt0ur"
		]);
		
		$rJson = $response->decodeResponseJson();
		
		$this->assertTrue(array_key_exists('access_token', $rJson));
        $response->assertStatus(200);
	}
	
    public function testRefreshToken()
    {
        $response = $this->post('api/login', [
			"email" => "matheuseejam@gmail.com",
			"password" => "p4yt0ur"
		]);
		
		$rJson = $response->decodeResponseJson();
		$token = $rJson['access_token'];
		
		$response = $this->get('api/refresh', [ "Authorization" => "Bearer ".$token ]);
        $response->assertStatus(200);
	}

	public function testToken()
    {
        $response = $this->post('api/login', [
			"email" => "matheuseejam@gmail.com",
			"password" => "p4yt0ur"
		]);
		
		$rJson = $response->decodeResponseJson();
		$token = $rJson['access_token'];
		
		$response = $this->get('api/funcionario', [ "Authorization" => "Bearer TOKEN INVÁLIDO" ]);
		$response->assertStatus(401);

		$response = $this->get('api/funcionario', [ "Authorization" => "Bearer ".$token ]);
		$response->assertStatus(200);
	}
}
