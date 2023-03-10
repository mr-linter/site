<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LogRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, \Closure $next)
    {
        $requestId = (string) Str::uuid();

        Log::shareContext([
            'request_id' => $requestId
        ]);

        Log::info(
            sprintf('Given request at %s %s', $request->method(), $request->url()),
        );

        $started = microtime(true);

        $result = $next($request);

        Log::info(
            sprintf('Handled request at %s %s', $request->method(), $request->url()),
            [
                'duration' => microtime(true) - $started,
            ],
        );

        return $result;
    }
}
