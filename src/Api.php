<?php

namespace Bravist\Cnvex;

class Api
{
    /**
     * Get enterprise profile
     * @return void
     */
    public function getEnterpriseProfile()
    {
        if (! $this->getConfig('enterprise_uuid')) {
            throw new \Exception("重庆宜配科技有限公司企账通企业号不存在！");
        }
        $parameters = [
            'service' => 'queryUser',
            'outUserId' => $this->getConfig('enterprise_uuid')
        ];
        $resJson = $this->post($parameters);
        $response = json_decode($resJson);
        if ($response->resultCode != 'EXECUTE_SUCCESS' &&
             $response->resultCode != 'EXECUTE_PROCESSING') {
            throw new \Exception('查询企账通企业号失败： '. $response->resultMessage);
        }
        //获取账户信息
        $account = $response->userInfo[0];
        // 手机号码未实名认证
        if ($account->mobileNoAuth != 'AUTH_OK') {
            throw new \Exception('手机号码未实名认证');
        }
        // 身份信息未实名认证
        if ($account->realNameAuth != 'AUTH_OK') {
            throw new \Exception('身份信息未实名认证');
        }
        // 未绑定银行卡
        if ($account->bankCardCount < 1) {
            throw new \Exception('未绑定银行卡');
        }
        return $account;
    }
}
