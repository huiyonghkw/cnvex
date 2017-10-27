<?php

use Bravist\Cnvex\Handlers\Http;
use Bravist\Cnvex\SignatureManager;
use GuzzleHttp\Client;
use Bravist\Cnvex\Api;
use PHPUnit\Framework\TestCase;

class HttpTest extends TestCase
{
    private function getDefaults()
    {
        return [
                'signature' => [
                    'default' => 'md5',
                    'md5' => [
                        'driver' => 'md5',
                        'options' => [
                            'signKey' => '20ad542cba99a9330dce0429dbeec55ec'
                        ]
                    ]
                ],
                'cnvex' => [
                    'protocol' => 'HTTP_FORM_JSON',
                    'signType' => 'MD5',
                    'partnerId' => 'c17100913073600200074',
                    'version' => '1.0',
                    'apiHost' => 'http://open.cnvex.cn/gateway.html',
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
        $res = $http->queryUser('', '47301000-b276-11e7-a4ef-1d9415e7f289');
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

    public function testqueryTransfer()
    {
        $app = $this->getDefaults();
        $manager = new SignatureManager($app['signature']);
        $http = new Api($manager, new Client(), $app['cnvex']);
        $res = $http->queryTransfer('311710242030203990');
        $this->assertObjectHasAttribute('tradeStatus', $res);
    }


    public function testqueryTransfers()
    {
        $app = $this->getDefaults();
        $manager = new SignatureManager($app['signature']);
        $http = new Api($manager, new Client(), $app['cnvex']);
        $res = $http->queryTransfers('17092720111513000002');
        $this->assertObjectHasAttribute('rows', $res);
    }


    public function testQueryRechargesAndwithdrawals()
    {
        $app = $this->getDefaults();
        $manager = new SignatureManager($app['signature']);
        $http = new Api($manager, new Client(), $app['cnvex']);
        $res = $http->queryRechargesAndwithdrawals('17101623164200000001');
        $this->assertObjectHasAttribute('rows', $res);
    }

    public function testQueryBankCards()
    {
        $app = $this->getDefaults();
        $manager = new SignatureManager($app['signature']);
        $http = new Api($manager, new Client(), $app['cnvex']);
        $res = $http->queryBankCards('17101623164200000001');
        $this->assertObjectHasAttribute('bankCardInfos', $res);
    }

    public function testUnbindBankCard()
    {
        $app = $this->getDefaults();
        $manager = new SignatureManager($app['signature']);
        $http = new Api($manager, new Client(), $app['cnvex']);
        $res = $http->unbindBankCard('17101623164200000001', '17101710222500400735');
        $this->assertNotNull($res);
    }
}
