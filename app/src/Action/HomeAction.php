<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Slim\Views\Twig;

class HomeAction {

    protected $view;

    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

    public function __invoke (RequestInterface $request, ResponseInterface $response, $args) {
        $data = array(
            'title' => "Imagine",
            'text' => 'a skeleton application Slim 3 based.'
        );

        return $this->view->render($response, 'home.html.twig', $data);
    }

}