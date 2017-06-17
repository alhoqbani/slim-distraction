<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @property  \Slim\Views\Twig             $view
 * @property  \Slim\Router                 router
 * @property  \App\Services\ServiceFactory services
 * @property  \App\Cache\CacheInterface    cache
 */
class NewsController extends BaseController
{
    
    public function show(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        dump($this->cache);
        $service = $this->services->get($args['service']);
        
        return $response->withJson($service);
    }
}
