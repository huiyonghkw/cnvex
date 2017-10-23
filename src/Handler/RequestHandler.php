<?php

namespace Bravist\Cnvex\Handler;

class RequestHandler
{
    public function __construct(array $config = [])
    {
        $this->setConfig($config);
    }

    public $requestNo;



    public function setRequestNo()
    {
    }

    /**
     * Get general parameters
     * @return array
     */
    private function configureDefaults()
    {
        return [
            'requestNo'    => $this->makeRequestNo(),
            'merchOrderNo'  => $this->getMerchOrderNo(),
            'version'   => $this->getConfig('version'),
            'partnerId' => $this->getConfig('partnerId'),
            'signType'  => $this->getConfig('signType'),
            'protocol' => $this->getConfig('protocol')
        ];
    }

    /**
    * Get merchOrderNo
    * @return integer
    */
    protected function getMerchOrderNo()
    {
        return isset($this->merchOrderNo) ? $this->merchOrderNo : $this->makeRequestNo();
    }

    /**
     * Make request no
     * @return integer
     */
    protected function makeRequestNo()
    {
        list($usec, $sec) = explode(' ', microtime());
        return date('YmdHis') . intval((float) $sec + ((float) $usec * 100000));
    }
}
