<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class ConnectionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        $connection = session('db_connection', 'pgsql');

        DB::purge($connection);
        config(['database.default' => $connection]);
        DB::reconnect($connection);
        DB::reconnect($connection); 

        return $next($request);
    }
}
