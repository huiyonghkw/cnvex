<?php 

namespace Bravist\Cnvex\Contracts;

interface Signer
{
    public function sign($sign);
    
    public function verify($string, $key);
}
