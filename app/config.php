<?php
/**
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */
// Setting up configuration values and  dependency tree

use \Imrei\AddRest\Components\Container;
use \Imrei\AddRest\Components\Request;

$container = new Container();

$container->set('database.dsn', 'sqlite:' . __DIR__ . '/data/add-rest.sq3');

$container->setReusable('pdo', function ($c) {
    $pdo = new \PDO($c->get('database.dsn'));
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    return $pdo;
});

$container->setReusable('repository.address', function ($c) {
    return new Imrei\AddRest\Model\Repository\AddressRepository($c->get('pdo'));
});

$container->set('service.address', function ($c) {
    return new Imrei\AddRest\Services\AddressService($c->get('repository.address'));
});

$container->set('controller.address', function ($c) {
    return new Imrei\AddRest\Controller\AddressController($c->get('service.address'));
});

$container->setReusable('router', function ($c) {
    return new Imrei\AddRest\Components\Router($c);
});

// Setting up routes
/* @var $router Imrei\AddRest\Components\Router */
$router = $container->get('router');

$router->addRoute('/address', Request::HTTP_GET, 'controller.address', 'getOneAction');

return $container;
