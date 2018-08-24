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
        require __DIR__.'/settings.php';
        $app = [
                'signature' => [
                    'default' => 'md5',
                    'md5' => [
                        'driver' => 'md5',
                        'options' => [
                            'signKey' => $contexts['sign_key']
                        ]
                    ]
                ],
                'cnvex' => [
                    'protocol' => 'HTTP_FORM_JSON',
                    'signType' => 'MD5',
                    'partnerId' => $contexts['partner_id'],
                    'version' => '1.0',
                    'apiHost' => $contexts['api_host'],
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
        $res = $this->http->queryUser('17121415551700300189', '');
        print_r($res);
        $this->assertObjectHasAttribute('userId', $res);
    }

    public function testQueryUserBalance()
    {
        $this->getDefaults();
        $res = $this->http->queryUserBalance('17121317100200200161');
        print_r($res);
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
        $res = $this->http->transfer('17262020180809160431992102821', 'http://open.dev.weipeiapp.com/api/cnvex/notify', '0.1', '18080313225800300370');
        print_r($res);
        $this->assertNotNull($res);
    }

    public function testCreateTransaction()
    {
        $this->getDefaults();
        $res = $this->http->createTransaction('18080313225800300370向18080313014200200421企账通账户转0.1', '0.1', '18080313014200200421', 'http://open.dev.weipeiapp.com/api/cnvex/notify', '17262020180809160431992102821', '18080313225800300370');
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

    public function testGetRegisterRedirectUrl()
    {
        $this->getDefaults();
        $res = $this->http->getRegisterRedirectUrl('7F1EEBC2-7D8A-4072-95AB-EFA61E80EE3C');
        print_r($res);
        $this->assertNotNull($res);
    }

    public function testGetTradeRedirectPayUrl()
    {
        $this->getDefaults();
        $res = $this->http->getTradeRedirectPayUrl('17122514514900200152', '17262020171204160431992102821',  '0.01', 'http://open.dev.weipeiapp.com/api/cnvex/notify', 'http://open.dev.weipeiapp.com/api/cnvex/notify');
        print_r($res);
        $this->assertNotNull($res);
    }

    /**
     * 同步响应结果，该接口没有异步通知 
     * (
    [noRefundAmount] => 0.09
    [resultCode] => EXECUTE_SUCCESS
    [sign] => 3abac9b2b85f4ef7969f786290b283e1
    [resultMessage] => 成功
    [requestNo] => RQN201808090808421533811808
    [version] => 1.0
    [appClient] =>
    [protocol] => HTTP_FORM_JSON
    [success] => 1
    [service] => tradeRefund
    [origMerchOrdeNo] => 17262020180809160431992102821
    [signType] => MD5
    [merchOrderNo] => SYS201808090808421533811799
    [partnerId] => 17100913073600200074
    [tradeRefundStatus] => PART_REFUND
    [refundAmount] => 0.01
)
     * @return [type] [description]
     */
    public function testRefund()
    {
        $this->getDefaults();
        $res = $this->http->refund('17262020180809160431992102821', '0.01',  '质量问题，需要退款', 'http://e4cbd3ab.ngrok.io/api/notify/weipeiopen');
        print_r($res);
        $this->assertNotNull($res);
    }
}
