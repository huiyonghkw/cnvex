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
                        'signKey' => '06f7aab08aa2431e6dae6a156fc9e0b4'
                    ]
                ]
            ],
            'cnvex' => [
                'protocol' => 'HTTP_FORM_JSON',
                'signType' => 'MD5',
                'partnerId' => 'test',
                'version' => '1.0',
                'apiHost' => 'http://222.180.209.130:8810/gateway.html',
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
            'outUserId' => 'E55752A1-B364-4C37-9442-E9D6C0CC8422',
            // 'userId' => '17081609495213000019'
        ];
        $this->assertObjectHasAttribute('userInfo', json_decode($http->post($parameters)));
    }
}
