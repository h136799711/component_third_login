<?php
require __DIR__ . '/common.php';
$giteeOAuth = new \by\component\third_login\Gitee\OAuth2;
$giteeOAuth->displayLoginAgent();