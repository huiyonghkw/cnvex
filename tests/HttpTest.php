<?php

use Bravist\Cnvex\Handlers\Http;
use Bravist\Cnvex\SignatureManager;
use GuzzleHttp\Client;
use Bravist\Cnvex\Api;
use PHPUnit\Framework\TestCase;

class HttpTest extends TestCase
{
    protected $http;

    private function getDefaults()
    {
        $app = [
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
        $manager = new SignatureManager($app['signature']);
        $this->http = new Api($manager, new Client(), $app['cnvex']);
    }

    public function testQiZhangTongCanRequest()
    {
        $this->getDefaults();
        $parameters = [
            'service' => 'queryUser',
            // 'outUserId' => 'E55752A1-B364-4C37-9442-E9D6C0CC8422',
            'userId' => '17092720111513000002'
        ];
        $this->assertObjectHasAttribute('userInfo', $this->http->post($parameters));
    }

    public function testQueryUser()
    {
        $this->getDefaults();
        $res = $this->http->queryUser('17101623163100000011', '');
        print_r($res);
        $this->assertObjectHasAttribute('userId', $res);
    }

    public function testQueryUserBalance()
    {
        $this->getDefaults();
        $res = $this->http->queryUserBalance('17092720111513000002');
        $this->assertObjectHasAttribute('userId', $res);
    }

    public function testSendSMS()
    {
        $this->getDefaults();
        $res = $this->http->sendCaptcha('15390438190');
        $this->assertTrue($res);
    }

    public function testRegisterUser()
    {
        $this->getDefaults();
        $res = $this->http->registerUser('D3665263-7925-4858-A461-E90368437622', 398129, 15390438190, '程会勇', '513701198709184016', '6222024402027814403');
        $this->assertNotNull($res);
    }

    public function testqueryTransfer()
    {
        $this->getDefaults();
        $res = $this->http->queryTransfer('311710242030203990');
        $this->assertObjectHasAttribute('tradeStatus', $res);
    }


    public function testqueryTransfers()
    {
        $this->getDefaults();
        $res = $this->http->queryTransfers('17092720111513000002');
        $this->assertObjectHasAttribute('rows', $res);
    }


    public function testQueryRechargesAndwithdrawals()
    {
        $this->getDefaults();
        $res = $this->http->queryRechargesAndwithdrawals('17101623164200000001');
        $this->assertObjectHasAttribute('rows', $res);
    }

    public function testQueryBankCards()
    {
        $this->getDefaults();
        $res = $this->http->queryBankCards('17101623164200000001');
        $this->assertObjectHasAttribute('bankCardInfos', $res);
    }

    public function testBindPrivateBankCard()
    {
        $this->getDefaults();
        $res = $this->http->bindPrivateBankCard('17090516350500300001', '手机号码', '验证码', '银行卡号');
        $this->assertNotNull($res);
    }

    public function testBindPublicBankCard()
    {
        $this->getDefaults();
        $res = $this->http->bindPublicBankCard('17090516350500300001', '手机号码', '验证码', '银行卡号', '银行名称，如：中国邮政储蓄银行', '银行简称，如：PSBC', '开户省，如：重庆', '开户市，如：重庆');
        $this->assertNotNull($res);
    }

    public function testUnbindBankCard()
    {
        $this->getDefaults();
        $res = $this->http->unbindBankCard('17101623164200000001', '17101710222500400735');
        $this->assertNotNull($res);
    }

    public function testQuerySupportCity()
    {
        $this->getDefaults();
        $res = $this->http->querySupportCity();
        $this->assertNotNull($res);
    }

    public function testQueryOperator()
    {
        $this->getDefaults();
        $res = $this->http->queryOperator('17101710025600000001');
        print_r($res);
        $this->assertNotNull($res);
    }

    public function testGetWalletRedirectUrl()
    {
        $this->getDefaults();
        $res = $this->http->getWalletRedirectUrl('17090516275900200008', '', '', '', '17101710025600000001');
        print_r($res);
        $this->assertNotNull($res);
    }

    public function testTransfer()
    {
        $this->getDefaults();
        $res = $this->http->transfer('17262020171204160431992102820', 'http://open.dev.weipeiapp.com/api/cnvex/notify', '3060', '17101623163100000288');
        print_r($res);
        $this->assertNotNull($res);
    }

    public function testCreateTransaction()
    {
        $this->getDefaults();
        $res = $this->http->createTransaction('58速运（启派）监管账户向取款账户转款3060元', '3060', '17101623163100000278', 'http://open.dev.weipeiapp.com/api/cnvex/notify', '17262020171204160431992102820', '17101623163100000288');
        print_r($res);
        $this->assertNotNull($res);
    }

    public function testWithdraw()
    {
        $this->getDefaults();
        $res = $this->http->withdraw('代扣绑卡ID', '用户UserId', '用户账户', '0.01', 'http://open.dev.weipeiapp.com/api/cnvex/notify', '2017-11-17 10:10:10', 'cnvex SDK提现测试');
        print_r($res);
        $this->assertNotNull($res);
    }
}
