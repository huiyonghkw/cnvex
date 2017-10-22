<?php

namespace Bravist\Cnvex\Signer;

use Bravist\Cnvex\Signer\AbstractSigner;
use Bravist\Cnvex\Contracts\Signer;

class MD5 extends AbstractSigner implements Signer
{
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
