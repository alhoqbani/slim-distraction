<?php

use App\Http\Controllers\Api\NewsController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

$app->group('/api', function () {
    $this->get('/news/{service}', NewsController::class . ':show');
    
    
    
    
    
    $this->get('/', function (ServerRequestInterface $request, ResponseInterface $response, $args) {
        return $response->withJson([
            "data" => [
                'message' => "Welcome to Your new api, Enjoy",
                'status'  => 200,
            ],
        ], 200);
    });
});

