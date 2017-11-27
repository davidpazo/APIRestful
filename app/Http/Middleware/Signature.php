<?php

namespace App\Http\Middleware;

use Closure;

class Signature
{
    /**
     * Este middleware añade una cabezera con una firma a cada una de las peticiones.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$header ='X-Name')
    {
        $response = $next($request);
        $response->headers->set($header,config('app.name'));
        return $response;
    }
}
