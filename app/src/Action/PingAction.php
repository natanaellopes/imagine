<?php

namespace App\Action;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PingAction
{

    public function __invoke(RequestInterface $request, ResponseInterface $response, $args)
    {
        return $response->withJson(['time' => time()]);
    }

}