<?php

use Bravist\Cnvex\Handlers\Http;
use Bravist\Cnvex\SignatureManager;
use GuzzleHttp\Client;
use Bravist\Cnvex\Api;

class HttpTest extends PHPUnit_Framework_TestCase
{
    private function getDefaults()
    {
        return [
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
    }

    public function testQiZhangTongCanRequest()
    {
        $app = $this->getDefaults();
        $manager = new SignatureManager($app['signature']);
        $http = new Http($manager, new Client(), $app['cnvex']);
        $parameters = [
            'service' => 'queryUser',
            // 'outUserId' => 'E55752A1-B364-4C37-9442-E9D6C0CC8422',
            'userId' => '17092720111513000002'
        ];
        $this->assertObjectHasAttribute('userInfo', $http->post($parameters));
    }

    public function testQueryUser()
    {
        $app = $this->getDefaults();
        $manager = new SignatureManager($app['signature']);
        $http = new Api($manager, new Client(), $app['cnvex']);
        $res = $http->queryUser('17092720111513000002');
        $this->assertObjectHasAttribute('userId', $res);
    }

    public function testQueryUserBalance()
    {
        $app = $this->getDefaults();
        $manager = new SignatureManager($app['signature']);
        $http = new Api($manager, new Client(), $app['cnvex']);
        $res = $http->queryUserBalance('17092720111513000002');
        $this->assertObjectHasAttribute('userId', $res);
    }

    public function testSendSMS()
    {
        $app = $this->getDefaults();
        $manager = new SignatureManager($app['signature']);
        $http = new Api($manager, new Client(), $app['cnvex']);
        $res = $http->sendCaptcha('15390438190');
        $this->assertTrue($res);
    }

    public function testRegisterUser()
    {
        $app = $this->getDefaults();
        $manager = new SignatureManager($app['signature']);
        $http = new Api($manager, new Client(), $app['cnvex']);
        $res = $http->registerUser('D3665263-7925-4858-A461-E90368437643', 111111, 15390438190, '程会勇', '513701198709184016', '6222024402027814403');
        $this->assertNotNull($res);
    }
}
