<?php
/**
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */
namespace Imrei\AddRest\Tests\Controller;

use Imrei\AddRest\Controller\AddressController;
use Imrei\AddRest\Model\Entity\Address;
use Imrei\AddRest\Services\AddressService;
use Imrei\AddRest\Exceptions\Http\HttpNotFoundException;
use Imrei\AddRest\Components\Request;
use Imrei\AddRest\Components\Response;
use Imrei\AddRest\View\Interfaces\Renderable;

class AddressControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Build a mock address service without running the constructor
     *
     * @param array $methods
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockService(array $methods)
    {
        $mockServiceBuilder = $this->getMockBuilder(AddressService::class);
        $mockServiceBuilder
            ->disableOriginalConstructor()
            ->setMethods($methods)
        ;
        return $mockServiceBuilder->getMock();
    }

    /**
     * Test getting one address item
     */
    public function testGetOneAction()
    {
        $address = new Address('Foo', '0655512345', 'Bar St');

        $service = $this->getMockService(['getEntityById']);
        $service
            ->expects($this->once())
            ->method('getEntityById')
            ->with('1234')
            ->will($this->returnValue($address))
        ;

        $addressArray = $service->convertEntityToArray($address);

        $request = new Request([], ['id' => 1234, 'foo' => 'bar']);

        $view = $this->getMockBuilder(Renderable::class)
            ->setMethods(['render'])
            ->getMock();
        ;
        $view
            ->expects($this->once())
            ->method('render')
            ->with($addressArray)
            ->will($this->returnValue($addressArray))
        ;

        $controller = $this->getMockBuilder(AddressController::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs([$service])
            ->setMethods(['makeView'])
            ->getMock()
        ;
        $controller
            ->expects($this->once())
            ->method('makeView')
            ->with($request)
            ->will($this->returnValue($view))
        ;

        $response = $controller->getOneAction($request);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($addressArray, $response->getBody());
    }

    /**
     * Test throwing an exception when address not found with different
     * GET input arrays
     *
     * @param array $getParams
     *
     * @dataProvider getNotFoundGetParams
     */
    public function testGetOneNotFound(array $getParams)
    {
        $service = $this->getMockService(['getEntityById']);
        if (array_key_exists('id', $getParams)) {
            $service
                ->expects($this->once())
                ->method('getEntityById')
                ->with('1234')
                ->will($this->returnValue(null))
            ;
        }

        $this->setExpectedException(HttpNotFoundException::class);

        $request = new Request([], $getParams);

        $controller = new AddressController($service);
        $notReturned = $controller->getOneAction($request);
        $this->assertNotNull($notReturned, "Execution did not stop on exception thrown");
    }

    /**
     * Data provider for $this->testGetOneNotFound()
     *
     * @return array
     */
    public function getNotFoundGetParams()
    {
        return [
            [['id' => 1234]],
            [[]],
            [['foo' => 'bar']]
        ];
    }
}
