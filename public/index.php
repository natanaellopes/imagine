<?php

$loader = require '../vendor/autoload.php';
$loader->addPsr4('App\\', '../app/src');

$settings = require '../app/settings.php';

if($settings['settings']['displayErrorDetails']) {
    error_reporting(E_ALL);
    ini_set('display_errors', true);
}

$app = new Slim\App($settings);

require '../app/dependencies.php';

require '../app/routes.php';

$app->run();
