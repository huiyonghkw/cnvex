# The [e.cnvex.cn](http://bxapi.cnvex.cn/apiService/intoSchemeService.html) API PHP SDK


## 简介
[企账通2.0](http://www.cnvex.cn/ProductQzt.html) 是重庆汽摩交易所其他企业级交易计算工具，本项目是PHP版本接口实现，官方接口文档参考[这里](http://bxapi.cnvex.cn/apiService/intoSchemeService.html)。目前支持以下功能：
- 微信、支付宝原生APP支付，二维码支付
- 账户余额支付（转账）
- 账户注册、绑定银行卡
- 查询交易记录


另外，项目支持Laravel Framework快速集成，所有接口都已做单元测试，具体参考`tests`目录文件。

扩展包依赖
+ PHP 5.6+ || PHP 7.0+
+ guzzlehttp/guzzle
+ phpunit/phpunit
+ illuminate/log


## 安装 Cnvex.cn PHP SDK

### 使用[composer](https://getcomposer.org/)
> composer 是php的包管理工具， 通过composer.json里的配置管理依赖的包，同时可以在使用类时自动加载对应的包, 在你的composer.json中添加如下依赖

执行
```
composer require bravist/cnvex
```

使用 Composer 的 autoload 引入
```php
require_once('vendor/autoload.php');
```

### 手动引入
``` php
require_once('/path/to/cnvex/api.php');
```


## For Laravel

Add the following line to the section `providers` of `config/app.php`:

```php
'providers' => [
    //...
    Bravist\Cnvex\ServiceProvider::class,
],
```

publish the configuration:
```
php artisan vendor:publish --provider="Bravist\Cnvex\ServiceProvider"
```

as optional, you can use facade:

```php
'aliases' => [
    'Cnvex' => Bravist\Cnvex\Facade\Cnvex::class,
    'CnvexSigner' => Bravist\Cnvex\Facade\Signature::class
],
```

support package auto discover on laravel 5.5.

## Usage

```php
# 数据签名
CnvexSigner::sign(['tody' => 'hello']);

# 数据验签
CnvexSigner::verify(['today' => 'hello'], 'hello'); // false

CnvexSigner::verify(['tody' => 'hello'], 'c8ef86e1cab2e2daeabdc9c516120463'); // true


# 查询企账通用户信息，更多接口参考下面开放接口部分
Cnvex::queryUser('17090516435200300009');


```


## For Lumen

Add the following line to `bootstrap/app.php` after `// $app->withEloquent();`

```php
...
// $app->withEloquent();
$app->register(Bravist\Cnvex\ServiceProvider::class);
...
```


## 开放接口
+ 查询用户信息 [queryUser](https://github.com/bravist/cnvex/blob/master/src/Api.php#L15)
+ 查询用户余额 [queryUserBalance](https://github.com/bravist/cnvex/blob/master/src/Api.php#L51)
+ 发送短信验证码 [sendCaptcha](https://github.com/bravist/cnvex/blob/master/src/Api.php#L69)
+ 注册个人类型用户[registerUser](https://github.com/bravist/cnvex/blob/master/src/Api.php#L93)
+ 查询单笔转账交易 [queryTransfer]https://github.com/bravist/cnvex/blob/master/src/Api.php#L118)
+ 统一收单交易创建接口 ['createTransaction'](https://github.com/bravist/cnvex/blob/master/src/Api.php#L156)
+ 微信扫码支付 [payWechatQrCode](https://github.com/bravist/cnvex/blob/master/src/Api.php#L180)
+ 查询多笔转账交易记录 [queryTransfers](https://github.com/bravist/cnvex/blob/master/src/Api.php#L207)
