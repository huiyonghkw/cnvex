<?php 

namespace Bravist\Cnvex\Contacts;

interface Signer
{
    public function sign($signString);
    
    public function verify($string, $key);
}
