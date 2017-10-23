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
                        'signKey' => 'ac59f0714d937822d990d880a6754fc7'
                    ]
                ]
            ],
            'cnvex' => [
                'protocol' => 'HTTP_FORM_JSON',
                'signType' => 'MD5',
                'partnerId' => '17083115321700300060',
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
            'outUserId' => '3742fa50-b275-11e7-b28c-372ca50f1589',
            // 'userId' => '17081609495213000019'
        ];
        $this->assertObjectHasAttribute('userInfo', json_decode($http->post($parameters)));
    }
}
