<?php 

namespace Bravist\Cnvex\Handlers;

use Bravist\Cnvex\SignatureManager;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Bravist\Cnvex\Handlers\Util\Util;

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
        // var_dump($this->getApiHost());
        // var_dump($parameters);
        try {
            $response = $this->client->post($this->getApiHost(), [
                'form_params' => $parameters
            ]);
        } catch (RequestException $e) {
            throw $e;
        }
        return (string) $response->getBody();
    }
}
