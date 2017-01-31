<?php
/**
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */
namespace Imrei\AddRest\Tests\Model\Entity;

use Imrei\AddRest\Model\Entity\Address;
use Imrei\AddRest\Helpers\ReflectionHelper;

/**
 * Example test class
 */
class AddressTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider testValueProvider
     */
    public function testGetter($propertyName, $value)
    {
        $address = new Address();
        $getterName = 'get' . ucfirst($propertyName);
        ReflectionHelper::setProtectedPropertyValue($address, $propertyName, $value);
        $this->assertEquals($value, $address->{$getterName}());
    }

    /**
     * @dataProvider testValueProvider
     */
    public function testSetter($propertyName, $value)
    {
        $address = new Address();
        $setterName = 'set' . ucfirst($propertyName);
        $address->{$setterName}($value);
        $actualValue = ReflectionHelper::getProtectedPropertyValue($address, $propertyName);
        $this->assertEquals($value, $actualValue);
    }

    /**
     * Provider for test values for testing getters/setters
     *
     * @return array
     */
    public function testValueProvider()
    {
        return [
            ['id', 1234],
            ['name', 'Foo Bar'],
            ['phone', '0612345678'],
            ['street', 'Rembrandtplein']
        ];
    }

    /**
     * Testing the constructor
     */
    public function testConstructor()
    {
        $name = 'Foo Bar';
        $phone = '0656781234';
        $street = 'Leidseplein';

        $address = new Address($name, $phone, $street);
        $this->assertEquals($name, $address->getName());
        $this->assertEquals($phone, $address->getPhone());
        $this->assertEquals($street, $address->getStreet());
    }
}
