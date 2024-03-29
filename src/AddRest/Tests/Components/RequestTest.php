<?php

/**
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */

namespace Imrei\AddRest\Tests\Components;

use Imrei\AddRest\Components\Request;
use PHPUnit\Framework\TestCase;

/**
 * Testing the Request class
 */
class RequestTest extends TestCase
{
    /**
     * Test getting the defaults when there's no input for the constructor
     */
    public function testConstructorAndGettersEmptyInput()
    {
        $serverVars = [];
        $getParams = [];

        $request = new Request($serverVars, $getParams);
        $this->assertEquals(Request::HTTP_GET, $request->getHttpMethod());
        $this->assertEquals('/', $request->getPathInfo());
        $this->assertEmpty($request->getHttpGetParam('nothing'));
    }

    /**
     * Test with valid superglobals
     */
    public function testConstructorAndGettersValidInput()
    {
        $serverVars = ['REQUEST_METHOD' => 'PUT', 'PATH_INFO' => '/foo/bar'];
        $getParams = ['foo' => 'bar', 'baz' => 123];

        $request = new Request($serverVars, $getParams);
        $this->assertEquals(Request::HTTP_PUT, $request->getHttpMethod());
        $this->assertEquals('/foo/bar', $request->getPathInfo());
        $this->assertEmpty($request->getHttpGetParam('nonexistent'));
        $this->assertEquals('bar', $request->getHttpGetParam('foo'));
        $this->assertEquals(123, $request->getHttpGetParam('baz'));
    }
}
