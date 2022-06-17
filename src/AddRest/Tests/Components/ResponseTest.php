<?php

/**
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */

namespace Imrei\AddRest\Tests\Components;

use Imrei\AddRest\Components\Response;
use PHPUnit\Framework\TestCase;

/**
 * Testing the Response class
 */
class ResponseTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testSendHeaders()
    {
        $response = new Response();
        $response->addHeader('Content-type', 'application/json');
        $response->addHeader('X-FooBar', 'baz/qux');

        $this->assertTrue($response->sendHeaders());

        if (function_exists('xdebug_get_headers')) {
            $headers = xdebug_get_headers();
            $expected = [
                '/Content-type:\s*application\/json/',
                '/X-FooBar:\s*baz\/qux/'
            ];
            foreach ($expected as $expectedHeader) {
                $this->assertNotEmpty(preg_grep($expectedHeader, $headers));
            }
        }
    }

    public function testSendBody()
    {
        $bodyString = 'peanut butter icecream';
        $this->expectOutputString($bodyString);

        $response = new Response($bodyString);
        $response->sendBody();
    }

    public function testSend()
    {
        $response = $this->getMockBuilder(Response::class)
            ->setMethods(['sendHeaders', 'sendBody'])
            ->getMock()
        ;
        $response
            ->expects($this->once())
            ->method('sendHeaders')
        ;
        $response
            ->expects($this->once())
            ->method('sendBody')
        ;
        $response->send();
    }
}
