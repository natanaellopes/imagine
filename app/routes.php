<?php

$app->get('/', 'App\Action\HomeAction');

$app->group('/data', function () {
    $this->get('[/]', 'App\Controller\DataController:read');
    $this->post('[/]', 'App\Controller\DataController:create');
    $this->post('/{id}[/]', 'App\Controller\DataController:update');
    $this->delete('/{id}[/]', 'App\Controller\DataController:delete');
});

$app->get('/ping', 'App\Action\PingAction');
