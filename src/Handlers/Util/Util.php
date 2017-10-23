<?php

namespace Bravist\Cnvex\Handlers\Util;

abstract class Util
{
    public $requestNo;

    public $merchOrderNo;

    public $version = '1.0';

    public $partnerId;

    public $signType;

    public $protocol;

    public function getRequestNo()
    {
        list($usec, $sec) = explode(' ', microtime());
        $this->requestNo = date('YmdHis') . intval((float) $sec + ((float) $usec * 100000));
        return $this;
    }

    public function getMerchOrderNo()
    {
        return $this->merchOrderNo;
    }

    public function setMerchOrderNo($no)
    {
        $this->merchOrderNo = $no;
        return $this;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    public function getPartnerId()
    {
        return $this->partnerId;
    }

    public function setPartnerId($partner)
    {
        $this->partnerId = $partner;
        return $this;
    }

    public function getSignType()
    {
        return $this->signType;
    }

    public function setSignType($type)
    {
        $this->signType = $type;
        return $this;
    }

    public function getProtocol()
    {
        return $this->protocol;
    }

    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;
        return $this;
    }

    /**
     * Get general parameters
     * @return array
     */
    protected function configureDefaults()
    {
        return [
            'requestNo'     => $this->getRequestNo(),
            'merchOrderNo'  => $this->getMerchOrderNo(),
            'version'       => $this->getVersion(),
            'partnerId'     => $this->getPartnerId(),
            'signType'      => $this->getSignType(),
            'protocol'      => $this->getProtocol()
        ];
    }
}
