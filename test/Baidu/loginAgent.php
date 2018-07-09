<?php
require __DIR__ . '/common.php';
$baiduOAuth = new \by\component\third_login\Baidu\OAuth2;
$baiduOAuth->displayLoginAgent();