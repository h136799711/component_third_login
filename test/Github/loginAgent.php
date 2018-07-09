<?php
require __DIR__ . '/common.php';
$githubOAuth = new \by\component\third_login\Github\OAuth2;
$githubOAuth->displayLoginAgent();