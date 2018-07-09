<?php
require __DIR__ . '/common.php';
$wxOAuth = new \by\component\third_login\Weixin\OAuth2;
$wxOAuth->displayLoginAgent();