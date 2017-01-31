<?php
/**
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */
namespace Imrei\AddRest\Tests\Components;

use Imrei\AddRest\Components\Container;
use Imrei\AddRest\Exceptions\Components\ContainerException;

/**
 * Test class for the dependency injection container
 */
class ContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test storing scalar values
     *
     * @param string $key
     * @param mixed $value
     *
     * @dataProvider getStoreTestValues
     */
    public function testStoreValues($key, $value)
    {
        $container = new Container();
        $container->set($key, $value);
        $this->assertSame($value, $container->get($key));
    }

    /**
     * Data provider testing simple values
     *
     * @return array
     */
    public function getStoreTestValues()
    {
        return [
            ['foo', 1234],
            ['bar', 'string literal'],
            ['baz', true],
            ['qux', false],
            ['waldo', null],
            ['fred', array(1,2,3)]
        ];
    }

    /**
     * Test storing a callable function in the container
     *
     * Also tests using a "dependency".
     */
    public function testStoreCallable()
    {
        $container = new Container();
        $container->set('test.multiplier', 3);

        $callable = function ($container) {
            return 2 * $container->get('test.multiplier');
        };
        $container->set('test.double', $callable);

        $this->assertEquals(6, $container->get('test.double'));
    }

    /**
     * Test storing a callable creating an object for re-use
     */
    public function testStoreReusable()
    {
        $container = new Container();
        $container->set('test.foo', 234);

        $callable = function ($container) {
            $testObject = new \stdClass();
            $testObject->foo = $container->get('test.foo');
            return $testObject;
        };
        $container->setReusable('test.reused', $callable);

        $firstResult = $container->get('test.reused');
        $this->assertInstanceOf(\stdClass::class, $firstResult);
        $this->assertObjectHasAttribute('foo', $firstResult);
        $this->assertEquals(234, $firstResult->foo);

        $this->assertSame($firstResult, $container->get('test.reused'));
    }

    /**
     * Test throwing ContainerException when invalid key specified
     */
    public function testKeyNotFound()
    {
        $this->setExpectedException(ContainerException::class);
        $container = new Container();
        $neverUsed = $container->get('invalid.slot.name');
        $this->assertTrue($neverUsed, 'Expected exception was not thrown');
    }
}
