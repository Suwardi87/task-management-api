<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogRequest
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->user()) {
            $log = sprintf(
                "[%s] %s %s | User: %s | Role: %s | IP: %s | Status: %s",
                now()->toDateTimeString(),
                $request->method(),
                $request->path(),
                $request->user()->email,
                $request->user()->role,
                $request->ip(),
                $request->user()->status ? 'active' : 'inactive'
            );

            Log::channel('api_activity')->info($log);
        }

        return $response;
    }
}
