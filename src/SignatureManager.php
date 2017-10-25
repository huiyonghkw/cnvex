<?php
namespace Bravist\Cnvex;

use Closure;
use InvalidArgumentException;
use Bravist\Cnvex\Signers\MD5;

class SignatureManager
{
    /**
     * The application instance.
     *
     * @var @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * The array of resolved signers.
     *
     * @var array
     */
    protected $signers = [];

    /**
     * The registered custom driver creators.
     *
     * @var array
     */
    protected $customCreators = [];

    /**
     * Constructor.
     *
     * @param $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Resolve a signer instance.
     *
     * @param string $name
     *
     * @return \Bravist\Cnvex\Constracts\Signer
     */
    public function signer($name = null)
    {
        $name = $name ?: $this->getDefaultSigner();
        if (! isset($this->signers[$name])) {
            $this->signers[$name] = $this->resolve($name);
        }
        return $this->signers[$name];
    }

    /**
     * Get the name of the default signer.
     *
     * @return string
     */
    public function getDefaultSigner()
    {
        return $this->app['default'];
    }

    /**
     * resolve a signer.
     *
     * @param string $name
     *
     * @return \Bravist\Cnvex\Constracts\Signer
     */
    protected function resolve($name)
    {
        $config = $this->getConfig($name);
        if (is_null($config)) {
            throw new InvalidArgumentException("Signer [{$name}] is not defined.");
        }
        if (isset($this->customCreators[$config['driver']])) {
            return $this->callCustomCreator($config);
        }
        $driverMethod = 'create'.ucfirst($config['driver']).'Driver';
        if (method_exists($this, $driverMethod)) {
            return $this->{$driverMethod}($config['options']);
        }
        throw new InvalidArgumentException("Signer [{$name}] is not defined.");
    }

    public function callCustomCreator(array $config)
    {
        return $this->customCreators[$config['driver']]($this->app, $config['options']);
    }

    /**
     * create rsa signer.
     *
     * @param array $config
     *
     * @return \Bravist\Cnvex\Signers\MD5
     */
    public function createMD5Driver(array $config)
    {
        return new MD5($config);
    }

    public function extend($driver, Closure $callback)
    {
        $this->customCreators[$driver] = $callback;
        return $this;
    }

    /**
     * Get the signer configuration.
     *
     * @param string $name
     *
     * @return array
     */
    protected function getConfig($name)
    {
        return $this->app[$name];
    }

    /**
     * Dynamically call the default driver instance.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->signer()->$method(...$parameters);
    }
}
