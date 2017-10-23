<?php 

namespace Bravist\Cnvex\Contracts;

interface Signer
{
    public function sign($signString);
    
    public function verify($string, $key);
}
