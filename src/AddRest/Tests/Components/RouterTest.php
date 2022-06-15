<?php
/**
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */
namespace Imrei\AddRest\Tests\Components;

use Imrei\AddRest\Components\Router;
use Imrei\AddRest\Components\Container;
use Imrei\AddRest\Components\Request;
use Imrei\AddRest\Exceptions\Http\HttpNotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * Testing the Router class
 */
class RouterTest extends TestCase
{
    /**
     * @var Router pre-configured router
     */
    protected $router;

    /**
     * @var Container storing routes and controllers
     */
    protected $container;

    protected function setUp(): void
    {
        $this->container = new Container();

        $controller1 = $this->makeDummyController1();
        $this->container->set('controller.cont1', $controller1);

        $controller2 = $this->makeDummyController2();
        $this->container->set('controller.cont2', $controller2);

        $this->router = new Router($this->container);
        $this->router->addRoute('/cont1', Request::HTTP_GET, 'controller.cont1', 'getOneAction');
        $this->router->addRoute('/cont1', Request::HTTP_POST, 'controller.cont1', 'createOneAction');
        $this->router->addRoute('/cont2', Request::HTTP_GET, 'controller.cont2', 'getOneAction');
        $this->router->addRoute('/cont2', Request::HTTP_PUT, 'controller.cont2', 'updateOneAction');
    }

    protected function tearDown(): void
    {
        $this->router = null;
        $this->container = null;
    }

    public function testController1GET()
    {
        // $controller1, GET
        $request = new Request(['REQUEST_METHOD' => Request::HTTP_GET, 'PATH_INFO' => '/cont1'], []);
        $response = $this->router->dispatch($request);
        $this->assertEquals('cont1.getOne', $response);
    }

    public function testController1POST()
    {
        // $controller1, POST
        $request = new Request(['REQUEST_METHOD' => Request::HTTP_POST, 'PATH_INFO' => '/cont1'], []);
        $response = $this->router->dispatch($request);
        $this->assertEquals('cont1.createOne', $response);
    }

    public function testController2GET()
    {
        // $controller2, GET
        $request = new Request(['REQUEST_METHOD' => Request::HTTP_GET, 'PATH_INFO' => '/cont2'], []);
        $response = $this->router->dispatch($request);
        $this->assertEquals('cont2.getOne', $response);
    }

    public function testController2PUT()
    {
        // $controller2, PUT
        $request = new Request(['REQUEST_METHOD' => Request::HTTP_PUT, 'PATH_INFO' => '/cont2'], []);
        $response = $this->router->dispatch($request);
        $this->assertEquals('cont2.updateOne', $response);
    }

    public function testNotFoundPath()
    {
        $this->expectException(HttpNotFoundException::class);

        $request = new Request(['REQUEST_METHOD' => Request::HTTP_GET, 'PATH_INFO' => '/foobar'], []);
        $this->router->dispatch($request);
    }

    public function testNotFoundController()
    {
        $this->expectException(HttpNotFoundException::class);

        $this->router->addRoute('/cont3', Request::HTTP_GET, 'controller.cont3', 'getOneAction');
        $request = new Request(['REQUEST_METHOD' => Request::HTTP_GET, 'PATH_INFO' => '/cont3'], []);
        $this->router->dispatch($request);
    }

    public function testNotFoundControllerNotCallable()
    {
        $this->expectException(HttpNotFoundException::class);

        $this->container->set('controller.cont4', 'not a callable');
        $this->router->addRoute('/cont4', Request::HTTP_GET, 'controller.cont4', 'getOneAction');
        $request = new Request(['REQUEST_METHOD' => Request::HTTP_GET, 'PATH_INFO' => '/cont4'], []);
        $this->router->dispatch($request);
    }

    /**
     * Mock simple dummy controller1 with some actions
     */
    protected function makeDummyController1()
    {
        $controller1 = $this->getMockBuilder('DummyController1')
            ->disableAutoload()
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disableProxyingToOriginalMethods()
            ->setMethods(['getOneAction', 'createOneAction'])
            ->getMock()
        ;
        $controller1
            ->expects($this->any())
            ->method('getOneAction')
            ->will($this->returnValue('cont1.getOne'))
        ;
        $controller1
            ->expects($this->any())
            ->method('createOneAction')
            ->will($this->returnValue('cont1.createOne'))
        ;

        return $controller1;
    }

    /**
     * Mock simple dummy controller2 with some actions
     */
    protected function makeDummyController2()
    {
        $controller2 = $this->getMockBuilder('DummyController2')
            ->disableAutoload()
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disableProxyingToOriginalMethods()
            ->setMethods(['getOneAction', 'updateOneAction'])
            ->getMock()
        ;
        $controller2
            ->expects($this->any())
            ->method('getOneAction')
            ->will($this->returnValue('cont2.getOne'))
        ;
        $controller2
            ->expects($this->any())
            ->method('updateOneAction')
            ->will($this->returnValue('cont2.updateOne'))
        ;

        return $controller2;
    }
}
