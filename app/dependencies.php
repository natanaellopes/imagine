<?php

// DIC configuration
$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Services
// -----------------------------------------------------------------------------

// Twig
$container['view'] = function ($c) {
    $settings = $c->get('settings');
    $view = new Slim\Views\Twig($settings['view']['template_path'], $settings['view']['twig']);

    // Add extensions
    $view->addExtension(new Slim\Views\TwigExtension($c->get('router'), $c->get('request')->getUri()));
    $view->addExtension(new Twig_Extension_Debug());

    return $view;
};

// PDO
$container['db'] = function ($c) {
    $settings = $c->get('settings');

    $options = array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

    $db = new \PDO($settings['db']['dsn'], $settings['db']['username'], $settings['db']['password'], $options);
    $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);

    return $db;
};

// -----------------------------------------------------------------------------
// Action factories
// -----------------------------------------------------------------------------

$container[App\Action\HomeAction::class] = function ($c) {
    return new App\Action\HomeAction($c->get('view'));
};

$container[App\Controller\DataController::class] = function ($c) {
    return new App\Controller\DataController($c->get('db'));
};
