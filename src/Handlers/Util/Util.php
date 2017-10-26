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

    public $debug;

    public $apiHost;

    public $logger = null;

    public function __construct($logger = null)
    {
        $this->logger = $logger;
    }

    public function getRequestNo()
    {
        list($usec, $sec) = explode(' ', microtime());
        $this->requestNo = 'RQN' . date('YmdHis') . intval((float) $sec + ((float) $usec * 100000));
        return $this->requestNo;
    }

    public function getMerchOrderNo()
    {
        return $this->merchOrderNo;
    }

    /**
     * 设置外部交易号
     * @param string $outTradeNo
     */
    public function setMerchOrderNo($outTradeNo = '')
    {
        if ($outTradeNo) {
            $this->merchOrderNo = $outTradeNo;
        } else {
            list($usec, $sec) = explode(' ', microtime());
            $this->merchOrderNo = 'SYS' . date('YmdHis') . intval((float) $sec + ((float) $usec * 100000));
        }
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

    public function getDebug()
    {
        return $this->debug;
    }

    public function setDebug($debug)
    {
        $this->debug = $debug;
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
