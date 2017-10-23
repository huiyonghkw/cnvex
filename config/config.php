<?php

return [
        'signature' => [
            'default' => 'md5',
            'md5' => [
                'driver' => 'md5',
                'options' => [
                    'signKey' => env('CNVEX_SIGN_KEY', '06f7aab08aa2431e6dae6a156fc9e0b4')
                ]
            ]
        ],
        'api' => [
            'protocol' => 'HTTP_FORM_JSON',
            'signType' => 'MD5',
            'partnerId' => env('CNVEX_PARTNER_ID', 'test'),
            'version' => '1.0',
            'apiHost' => env('CNVEX_API_HOST', 'http://222.180.209.130:8810/gateway.html'),
            'debug' => env('APP_DEBUG', true),
            'notify' => env('CNVEX_NOTIFY', 'http://api.weipeiapp.com.dev/qzt/blance_pay/notify')
        ]
    ];
