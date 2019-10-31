<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		try {
			$user = JWTAuth::parseToken()->authenticate();
		} catch(\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
			return response([
				'erro' => true,
				'mensagem' => "Token inválido"
			], 401);
		} catch(\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
			return response([
				'erro' => true,
				'mensagem' => "Token expirado"
			], 401);
		} catch (\Exception $e) {
			return response([
				'erro' => true,
				'mensagem' => "Token não informado"
			], 401);
		}

        return $next($request);
    }
}
