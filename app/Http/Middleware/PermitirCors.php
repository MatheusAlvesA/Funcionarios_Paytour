<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Response;
use Closure;

class PermitirCors
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
		\header("Access-Control-Allow-Origin: *");

        $headers = [
            'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin, Authorization'
        ];
        if($request->getMethod() == "OPTIONS") {
			return Response::make('OK', 200, $headers);
        }

        $response = $next($request);
        foreach($headers as $key => $value)
            $response->header($key, $value);
        return $response;
    }
}
