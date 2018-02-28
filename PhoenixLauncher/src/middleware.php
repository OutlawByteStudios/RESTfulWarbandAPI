<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

require_once __DIR__ . '/../../Authenticator.php';

$app->add(new Authenticator());