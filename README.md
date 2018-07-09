# component_third_login

## 支持的登录平台

- QQ
- 微信网页扫码、微信内授权
- 微博
- 百度
- Github
- Gitee
- Coding
- 开源中国(OSChina)
- CSDN

> 后续将不断添加新的平台支持，也欢迎你来提交PR，一起完善！

## 安装

在您的composer.json中加入配置：

```json
{
    "require": {
        "itboye/component_third_login": "1.0.*"
    }
}
```

## 代码实例

下面代码以QQ接口举例，完全可以把QQ字样改为其它任意接口字样使用。

### 实例化

```php
$qqOAuth = new \by\component_third_login\QQ\OAuth2('appid', 'appkey', 'callbackUrl');
```

### 登录

```php
$url = $qqOAuth->getAuthUrl();
$_SESSION['QQ_STATE'] = $qqOAuth->state;
header('location:' . $url);
```

### 回调处理

```php
// 获取accessToken
$accessToken = $qqOAuth->getAccessToken($_SESSION['QQ_STATE']);

// 调用过getAccessToken方法后也可这么获取
// $accessToken = $qqOAuth->accessToken;
// 这是getAccessToken的api请求返回结果
// $result = $qqOAuth->result;

// 用户资料
$userInfo = $qqOAuth->getUserInfo();

// 这是getAccessToken的api请求返回结果
// $result = $qqOAuth->result;
****
// 用户唯一标识
$openid = $qqOAuth->openid;
```

### 解决第三方登录只能设置一个回调域名的问题

```php
// 解决只能设置一个回调域名的问题，下面地址需要改成你项目中的地址，可以参考test/QQ/loginAgent.php写法
$qqOAuth->loginAgentUrl = 'http://localhost/test/QQ/loginAgent.php';

$url = $qqOAuth->getAuthUrl();
$_SESSION['BY_QQ_STATE'] = $qqOAuth->state;
header('location:' . $url);
```
