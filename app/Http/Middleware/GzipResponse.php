<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GzipResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (in_array('gzip', $request->getEncodings()) && function_exists('gzencode')) {
            $content = $response->getContent();
            // Verify if content is string before compressing
            if (is_string($content) && !empty($content)) {
                $compressed = gzencode($content, 9);
                
                if ($compressed) {
                    $response->setContent($compressed);
                    $response->headers->add([
                        'Content-Encoding' => 'gzip',
                        'Content-Length'   => strlen($compressed),
                    ]);
                }
            }
        }

        return $response;
    }
}
