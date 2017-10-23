<?php
namespace Bravist\Cnvex;

use Bravist\Cnvex\SignatureManager;
use Bravist\Cnvex\Api;
use GuzzleHttp\Client;
use Laravel\Lumen\Application as LumenApplication;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Bootstrap.
     */
    public function boot()
    {
        $this->setupConfig();
    }
    /**
     * setupConfig.
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/../config/config.php');
        if ($this->app instanceof LaravelApplication) {
            if ($this->app->runningInConsole()) {
                $this->publishes([
                    $source => config_path('cnvex.php'),
                ]);
            }
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('cnvex');
        }
        $this->mergeConfigFrom($source, 'cnvex');
    }
    /**
     * Register the service provider.
     */
    public function registerSignature()
    {
        $this->app->bind(['Bravist\\Cnvex\\SignatureManager' => 'cnvex.sign'], function ($app) {
            return new SignatureManager(config('cnvex.signature'));
        });
    }
        
    public function register()
    {
        $this->registerSignature();
        
        $this->app->bind(Api::class, function ($app) {
            return new Api(app('cnvex.sign'), new Client(), config('cnvex.api'));
        });
    }
}
