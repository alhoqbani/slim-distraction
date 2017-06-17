<?php

$container = $app->getContainer();


$container['services'] = function ($c) {
    return new App\Services\ServiceFactory(
        new \GuzzleHttp\Client(),
        $c->cache
    );
};

$container['cache'] = function ($c) {
    $config = $c['settings']['cache']['connections']['redis'];
    $client = new Predis\Client([
        'scheme'   => $config['scheme'],
        'host'     => $config['host'],
        'port'     => $config['port'],
        'passowrd' => $config['passowrd'] ?? null,
    ]);
    
    return new \App\Cache\RedisAdapter($client);
};

$container['view'] = function ($c) {
    $config = $c['settings']['twig'];
    $view = new \Slim\Views\Twig(
        $config['viewsPath'],
        [
            'cache' => $config['enableCache'] ? $config['viewsCachePath'] : false,
        ]);
    
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $c['request']->getUri()));
    
    return $view;
};

$container['db'] = function ($c) {
    $config = $c['settings']['database'];
    $dsn = $config['driver'] . ':dbname=' . $config['dbname'] . ';host=' . $config['host'];
    
    $pdo = new \PDO($dsn, $config['username'], $config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    
    return $pdo;
};