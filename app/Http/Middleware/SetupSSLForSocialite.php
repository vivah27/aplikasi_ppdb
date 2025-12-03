<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetupSSLForSocialite
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Setup SSL certificate untuk Socialite di environment lokal
        if (config('app.env') === 'local') {
            // Attempt to use system certificate store
            $possiblePaths = [
                'C:/laragon/etc/ssl/cacert.pem',
                'C:\\laragon\\etc\\ssl\\cacert.pem',
                dirname(__DIR__, 2) . '/storage/cacert.pem',
            ];
            
            $certPath = null;
            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    $certPath = $path;
                    break;
                }
            }
            
            if ($certPath) {
                putenv('CURL_CA_BUNDLE=' . $certPath);
                $_ENV['CURL_CA_BUNDLE'] = $certPath;
                $_SERVER['CURL_CA_BUNDLE'] = $certPath;
            } else {
                // If no certificate found, allow insecure for local development
                // This is NOT recommended for production!
                putenv('NODE_TLS_REJECT_UNAUTHORIZED=0');
            }
        }

        return $next($request);
    }
}

