<?php 

namespace Bravist\Cnvex\Handlers;

use Bravist\Cnvex\SignatureManager;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Bravist\Cnvex\Handlers\Util\Util;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Http extends Util
{
    public $signer;

    public $client;

    public function __construct(
        SignatureManager $signer,
        Client $client,
        array $config
    ) {
        $this->signer = $signer;
        $this->client = $client;
        $this->setConfig($config);
    }

    /**
     * setConfig.
     *
     * @param array $config
     *
     * @return $this
     */
    public function setConfig(array $config)
    {
        foreach ($config as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    /**
     * HTTP post request
     * @param  array  $parameters
     * @return string
     */
    public function post(array $parameters = [])
    {
        if ($parameters) {
            $parameters = array_merge($this->configureDefaults(), array_filter($parameters));
        }
        $parameters['sign'] = $this->signer->signer()->sign($parameters);
        $this->logger('=====host=====');
        $this->logger($this->getApiHost());
        $this->logger('=====sign=====');
        $this->logger($parameters['sign']);
        $this->logger('=====parameters=====');
        $this->logger($parameters);
        try {
            $response = $this->client->post($this->getApiHost(), [
                'form_params' => $parameters
            ]);
        } catch (RequestException $e) {
            $this->logger('=====RequestException=====');
            $this->logger($e);
            throw $e;
        }
        return (string) $response->getBody();
    }

    public function logger($msg)
    {
        if ($this->getDebug()) {
            $log = new Logger('cnvex');
            $log->pushHandler(new StreamHandler(__DIR__ . '/logs/debug.log', Logger::DEBUG));
            $log->debug($msg);
        }
    }
}
