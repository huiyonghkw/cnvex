<?php

use Bravist\Cnvex\Handlers\Http;
use Bravist\Cnvex\SignatureManager;
use GuzzleHttp\Client;

class HttpTest extends PHPUnit_Framework_TestCase
{
    public function testQiZhangTongCanRequest()
    {
        $app = [
            'signature' => [
                'default' => 'md5',
                'md5' => [
                    'driver' => 'md5',
                    'options' => [
                        'signKey' => '20ad542cba99a9330dce0429dbeec55e'
                    ]
                ]
            ],
            'cnvex' => [
                'protocol' => 'HTTP_FORM_JSON',
                'signType' => 'MD5',
                'partnerId' => '17100913073600200074',
                'version' => '1.0',
                'apiHost' => 'http://open.cnvex.cn/gateway.html',
                // 'signKey' => '20ad542cba99a9330dce0429dbeec55e',
                'debug' => true,
                'notify' => [
                    'blance_pay' => 'http://api.weipeiapp.com.dev/qzt/blance_pay/notify'
                ]
            ]
        ];
        $manager = new SignatureManager($app['signature']);
        $http = new Http($manager, new Client(), $app['cnvex']);
        $parameters = [
            'service' => 'queryUser',
            'outUserId' => '6E101949-188B-4EED-BB55-8E8A7771863B',
            // 'userId' => '17081609495213000019'
        ];
        $http->post($parameters);
    }
}
