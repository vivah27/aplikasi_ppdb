<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory as SocialiteFactory;
use GuzzleHttp\Client;

class SocialiteSSLProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'local') {
            // Override Guzzle client untuk Socialite dengan SSL certificate handling
            $this->app->extend('Laravel\Socialite\SocialiteManager', function ($manager) {
                // Set environment variables untuk cURL
                $certPath = 'C:/laragon/etc/ssl/cacert.pem';
                if (file_exists($certPath)) {
                    putenv('CURL_CA_BUNDLE=' . $certPath);
                    $_ENV['CURL_CA_BUNDLE'] = $certPath;
                }
                
                return $manager;
            });
        }
    }
}

