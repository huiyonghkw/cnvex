<?php

namespace Bravist\Cnvex\Signers;

use Bravist\Cnvex\Signers\AbstractSigner;
use Bravist\Cnvex\Contracts\Signer;

class MD5 extends AbstractSigner implements Signer
{
    public $signKey;

    protected function getSignKey()
    {
        return $this->signKey;
    }

    public function setSignKey($key)
    {
        $this->signKey = $key;
        return $this;
    }

    /**
     * Sign the source
     * @param array $signString
     * @return string
     */
    public function sign($signString)
    {
        return md5($signString . $this->getSignKey());
    }

    /**
     * Verify the signed string
     * @param  array $string
     * @param  string $signedString
     * @return boolean
     */
    public function verify($string, $key)
    {
        return $this->sign($string) == $key;
    }
}
