<?php

namespace Bravist\Cnvex;

use Bravist\Cnvex\Handlers\Http;

class Api extends Http
{
    /**
     * 查询企账通2.0账户信息
     * @param  string $internalUid
     * @param  string $externalUid
     * @return object
     */
    public function queryUser($internalUid = '', $externalUid = '')
    {
        $response = $this->post([
            'service' => 'queryUser',
            'userId' => $internalUid,
            'outUserId' => $externalUid
        ]);
        if (!isset($response->userInfo[0])) {
            throw new \RuntimeException('未找到企账通用户');
        }
        $account = $response->userInfo[0];
        // 手机号码未实名认证
        if ($account->mobileNoAuth != 'AUTH_OK') {
            throw new \RuntimeException('企账通账户手机号码未实名');
        }
        // 身份信息未实名认证
        if ($account->realNameAuth != 'AUTH_OK') {
            throw new \RuntimeException('企账通账户身份信息未实名认证');
        }
        // 未绑定银行卡
        if ($account->bankCardCount < 1) {
            throw new \RuntimeException('企账通账户未绑定银行卡');
        }

        if ($account->status != 'ENABLE') {
            throw new \RuntimeException('企账通账户已被禁用');
        }

        return $account;
    }

    /**
     * 查询企账通账户余额信息
     * @param string $internalUid
     * @return object
     */
    public function queryUserBalance($internalUid)
    {
        $response = $this->post([
            'service' => 'queryAccount',
            'userId' => $internalUid
        ]);
        if (!isset($response->account)) {
            throw new \RuntimeException('企账通余额账户信息错误');
        }
        return $response->account;
    }

    /**
     * 发送注册、绑卡短信验证码
     * @param integer $mobile
     * @param string $internalUid
     * @return boolean
     */
    public function sendCaptcha($mobile, $internalUid = '')
    {
        $type = $internalUid ? 'BIND_BANK_CARD' : 'REGISTER';
        $response = $this->post([
            'service' => 'smsCapthaSend',
            'userId' => $internalUid,
            'mobile' => $mobile,
            'smsCaptchaType' => $type
        ]);
        return (boolean) $response->success;
    }

    /**
     * 注册个人企账通账户
     * @param  string $externalUid
     * @param  integer $captcha
     * @param  integer $mobile
     * @param  string $realname
     * @param  string $idCard
     * @param  string $bankCard
     * @param  string $from
     * @param  string $email
     * @return string
     */
    public function registerUser($externalUid, $captcha, $mobile, $realname, $idCard, $bankCard, $from = 'MOBILE', $email = '')
    {
        $response = $this->post([
            'service' => 'commonAuditRegister',
            'outUserId' => $externalUid,
            'type' => 'PERSON',
            'grade' => 'LV_1',
            'captcha' => $captcha,
            'email' => $email,
            'mobileNo' => $mobile,
            'registerClient' => $from,
            'personRegisterDto' => json_encode([
                'realName' => $realname,
                'certNo' => $idCard,
                'bankCard' => $bankCard
            ]),
        ]);
        return $response->userId;
    }
}
