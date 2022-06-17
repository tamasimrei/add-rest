<?php

/**
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */

namespace Imrei\AddRest\Tests\Services;

use Imrei\AddRest\Services\AddressService;
use Imrei\AddRest\Model\Entity\Address;
use Imrei\AddRest\Model\Repository\AddressRepository;
use PHPUnit\Framework\TestCase;

class AddressServiceTest extends TestCase
{
    public function testConvertToArray()
    {
        $repository = $this->getMockRepository();
        $service = new AddressService($repository);
        $address = new Address('Foo', '0655512345', 'Bar St');
        $addressArray = [
            'id' => null,
            'name' => 'Foo',
            'phone' => '0655512345',
            'street' => 'Bar St'
        ];
        $this->assertEquals($addressArray, $service->convertEntityToArray($address));
    }

    public function testGetEntityById()
    {
        $repository = $this->getMockRepository(['getById']);
        $address = new Address('Foo', '0655512345', 'Bar St');
        $repository
            ->expects($this->once())
            ->method('getById')
            ->with(1234)
            ->will($this->returnValue($address))
        ;
        $service = new AddressService($repository);
        $this->assertEquals($address, $service->getEntityById(1234));
    }

    /**
     * @return AddressRepository
     */
    protected function getMockRepository(array $methods = [])
    {
        $mockBuilder = $this->getMockBuilder(AddressRepository::class);
        $mockBuilder
            ->disableOriginalConstructor()
            ->setMethods($methods)
        ;

        return $mockBuilder->getMock();
    }
}
