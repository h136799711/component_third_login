<?php
require __DIR__ . '/common.php';
$baiduOAuth = new \by\component\third_login\Baidu\OAuth2($GLOBALS['oauth_baidu']['appid'], $GLOBALS['oauth_baidu']['appkey'], $GLOBALS['oauth_baidu']['callbackUrl']);
// 解决只能设置一个回调域名的问题，下面地址需要改成你项目中的地址，可以参考./loginAgent.php写法
// $baiduOAuth->loginAgentUrl = 'http://test.com/test/Baidu/loginAgent.php';
var_dump(
	'access_token:', $baiduOAuth->getAccessToken($_SESSION['BY_BAIDU_STATE']),
	'我也是access_token:', $baiduOAuth->accessToken,
	'请求返回:', $baiduOAuth->result
);
var_dump(
	'用户资料:', $baiduOAuth->getUserInfo(),
	'openid:', $baiduOAuth->openid
);