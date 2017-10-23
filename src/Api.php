<?php

namespace Bravist\Cnvex;

use Bravist\Cnvex\Handlers\Http;

class Api extends Http
{
    /**
     * 查询企账通2.0账户信息
     * @param  string $internalUUID
     * @param  string $externalUUID
     * @return object
     */
    public function queryUser($internalUUID = '', $externalUUID = '')
    {
        $response = $this->post([
            'service' => 'queryUser',
            'userId' => $internalUUID,
            'outUserId' => $externalUUID
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
     * 查询企账通账户余额
     * @return [type] [description]
     */
    public function queryUserBalance()
    {
    }
}
