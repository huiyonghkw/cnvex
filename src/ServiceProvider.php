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
        $this->app->singleton('cnvex.sign', function ($app) {
            return new SignatureManager(config('cnvex.signature'));
        });
    }

    public function register()
    {
        $this->registerSignature();
        $this->registerClassAliases();

        $this->app->singleton('cnvex', function ($app) {
            return new Api(app('cnvex.sign'), new Client(), config('cnvex.api'));
        });
    }

    /**
     * Register the class aliases.
     *
     * @return void
     */
    protected function registerClassAliases()
    {
        $aliases = [
            'cnvex.sign' => 'Bravist\\Cnvex\\SignatureManager',
            'cnvex' => 'Bravist\Cnvex\Api',
        ];

        foreach ($aliases as $key => $aliases) {
            foreach ((array) $aliases as $alias) {
                $this->app->alias($key, $alias);
            }
        }
    }
}
