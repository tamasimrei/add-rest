<?php
/**
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */
namespace Imrei\AddRest\Components;

use Imrei\AddRest\Exceptions\Http\HttpNotFoundException;
use Imrei\AddRest\Exceptions\Components\ContainerException;

/**
 * Simple REST-like HTTP router
 *
 * Now it only implements a one element path and HTTP method based routing.
 */
class Router
{
    /**
     * @var Container holding a local reference to the app's container
     */
    protected $container;

    /**
     * @var array
     */
    protected $routes = array();

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Add a route to be handled
     *
     * @param string $path
     * @param string $httpMethod
     * @param string $controllerKey
     * @param string $actionMethod
     */
    public function addRoute($path, $httpMethod, $controllerKey, $actionMethod)
    {
        $route = [$path => [$httpMethod => [$controllerKey, $actionMethod]]];
        $this->routes = array_replace_recursive($this->routes, $route);
    }

    /**
     * Dispatch (execute) request, find controller and method in
     * the container; return the Response
     *
     * @param Request $request
     * @return Response
     */
    public function dispatch(Request $request)
    {
        // We only use the last element of the path
        // to allow to use a versioned API later
        $path = '/' . basename($request->getPathInfo());
        $method = $request->getHttpMethod();

        if (! isset($this->routes[$path][$method])) {
            throw new HttpNotFoundException('No route configured');
        }

        list($controllerKey, $actionMethod) = $this->routes[$path][$method];

        try {
            $controller = $this->container->get($controllerKey);
        } catch (ContainerException $e) {
            throw new HttpNotFoundException('Controller not found');
        }

        if (! is_callable([$controller, $actionMethod])) {
            throw new HttpNotFoundException('Controller action not callable');
        }

        return call_user_func_array([$controller, $actionMethod], [$request]);
    }
}
