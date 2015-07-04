<?php
/**
 * This source file is copyrighted by Tamas Imrei <tamas.imrei@gmail.com>.
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */
// Entry point for simple RESTful API application, ie. Front Controller

// Setting up the application, e.g. autoloader
require_once __DIR__ . '/../app/bootstrap.php';

use Imrei\AddRest\Components\Request;
use Imrei\AddRest\Components\Response;
use Imrei\AddRest\Helpers\HttpHelper;
use Imrei\AddRest\Exceptions\Http\HttpException;

try {
    // Creating and populating the dependency tree
    $container = require_once __DIR__ . '/../app/config.php';

    // Compiling request
    $request = new Request($_SERVER, $_GET);

    // Serving the request, sending response
    $response = $container->get('router')->dispatch($request);
    /* @var $response Response */
    $response->send();

} catch (HttpException $e) {
    HttpHelper::exitWithStatus($e->getCode(), $e->getMessage());

} catch (Exception $e) {
    HttpHelper::exitWithStatus(500, 'Internal Server Error');
}
