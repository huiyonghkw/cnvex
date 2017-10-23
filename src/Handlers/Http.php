<?php 

namespace Bravist\Cnvex;

use Bravist\Cnvex\SignatureManager;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Bravist\Cnvex\Handlers\Util\Util;

class Http extends Util
{
    public $signer;

    public $client;

    public $apiHost;

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

    public function getApiHost()
    {
        return $this->apiHost;
    }

    public function setApiHost($host)
    {
        $this->apiHost = $host;
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
        $parameters['sign'] = $this->signer->sign($parameters);
        logger('=====host=====');
        logger($this->getApiHost());
        logger('=====sign=====');
        logger($parameters['sign']);
        logger('=====parameters=====');
        logger($parameters);
        try {
            $response = $this->client->post($this->getApiHost(), [
                'form_params' => $parameters
            ]);
        } catch (RequestException $e) {
            logger('=====RequestException=====');
            logger($e);
            throw $e;
        }
        return (string) $response->getBody();
    }
}
