<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;

class ClientSiteMiddleware
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
        if (!session()->has('tokenUser')) {
            session()->put('tokenUser',null);
        }
        $response = Http::withToken(session()->get('tokenUser'))
                            ->get(env("REST_API_ENDPOINT").'/api/cek-token');
        $dataResponse = json_decode($response);
        if ($dataResponse->status == true) {
            session()->put('userLogged',$dataResponse->data);

            return $next($request);
        } else {
            session()->put('userLogged',null);

            return redirect()->route('login')->with('danger','Silakan login terlebih dahulu!');
        }
    }
}
