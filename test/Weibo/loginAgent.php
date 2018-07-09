<?php
require __DIR__ . '/common.php';
$weiboOAuth = new \by\component\third_login\Weibo\OAuth2;
$weiboOAuth->displayLoginAgent();