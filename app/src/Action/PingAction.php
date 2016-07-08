<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;

class PingAction {

    public function __invoke (RequestInterface $request, ResponseInterface $response, $args) {
        return $response->withJson(['time' => time()]);
    }

}