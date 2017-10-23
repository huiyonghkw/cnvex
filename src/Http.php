<?php 

namespace Bravist\Cnvex;

use Bravist\Cnvex\SignatureManager;
use GuzzleHttp\Client;

class Http
{
    public $signer;

    public function __construct(SignatureManager $signer, array $config)
    {
        $this->signer = $signer;

        $this->setConfig($config);
    }
}
