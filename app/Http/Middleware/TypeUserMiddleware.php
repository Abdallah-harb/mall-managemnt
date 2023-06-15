<?php

namespace App\Http\Middleware;

use App\Http\Helper\ResponseHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TypeUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth('api')->user()->type != "manager"){
            return ResponseHelper::sendResponseError([],\Illuminate\Http\Response::HTTP_BAD_REQUEST,"You Are Not Manager to see this page");
        }
        return $next($request);
    }
}
