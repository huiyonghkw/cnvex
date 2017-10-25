<?php

namespace Bravist\Cnvex\Handlers;

use Bravist\Cnvex\SignatureManager;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use Bravist\Cnvex\Handlers\Util\Util;

class Http extends Util
{
    public $signer;

    public $client;

    public function __construct(
        SignatureManager $signer,
        Client $client,
        array $config,
        $logger = null
    ) {
        parent::__construct($logger);
        $this->signer = $signer;
        $this->client = $client;
        $this->setConfig($config);
    }

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
        if ($this->getDebug() && isset($this->logger)) {
            $this->logger->debug('===Request Api Host===');
            $this->logger->debug($this->getApiHost());
            $this->logger->debug('===Request Parameters===');
            $this->logger->debug($parameters);
        }
        try {
            $response = $this->client->post($this->getApiHost(), [
                'form_params' => $parameters
            ]);
        } catch (RequestException $e) {
            throw $e;
        }

        $res = json_decode((string) $response->getBody());
        if ($res->resultCode != 'EXECUTE_SUCCESS' &&
             $res->resultCode != 'EXECUTE_PROCESSING') {
            throw new \Exception('Server request error: '. $res->resultMessage);
        }
        return $res;
    }
}
