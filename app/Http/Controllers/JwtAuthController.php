<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JwtAuthController extends Controller {

	public function login(Request $r) {
        $credentials = [
			'email' => $r->input('email'),
			'password' => $r->input('password')
		];
		$token = auth()->attempt($credentials);

        if(!$token)
            return response()->json(['erro' => true, 'mensagem' => 'Unauthorized'], 401);

        return $this->respondWithToken($token);
    }

    public function logout() {
        auth()->logout();
        return response()->json([
			'erro' => false,
			'mensagem' => 'Deslogado com sucesso'
		]);
    }

    public function refresh() {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ]);
	}
	
}
