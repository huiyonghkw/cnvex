<?php
use Bravist\Cnvex\SignatureManager;
use PHPUnit\Framework\TestCase;

class SignatureManagerTest extends TestCase
{
    public function testDefaultSignerCanBeResolved()
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
            ]
        ];

        $manager = new SignatureManager($app['signature']);
        $context = [
          'clearAmount' => '0.00',
          'amount' => '4768',
          'tradeNo' => 'O00117102420302001056559',
          'profitAmount' => '0.00',
          'notifyTime' => '2017-10-24 20:30:30',
          'resultCode' => 'EXECUTE_SUCCESS',
          'requestNo' => '201709071040381504769624',
          'resultMessage' => '成功',
          'version' => '1.0',
          'tradeTime' => '2017-10-24 20:30:20',
          'protocol' => 'HTTP_FORM_JSON',
          'tradeName' => '郑持兰）使用企账通（微信APP支付）方式进行回款',
          'success' => 'true',
          'service' => 'wechatAppPay',
          'tradeStatus' => 'SUCCESS',
          'payeeUserId' => '17101623163100000288',
          'signType' => 'MD5',
          'partnerId' => '17100913073600200074',
          'profitStatus' => 'PROFIT_SUCCESS',
          'payerUserId' => '17101623163100000288',
          'tradeType' => 'WECHAT_APP_PAY',
          'merchOrderNo' => '311710242030203990'
        ];

        $this->assertEquals('d0ca680e85aff9af8302f594bd83a673', $manager->signer()->sign($context));
    }
}
