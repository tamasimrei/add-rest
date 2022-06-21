<?php

namespace spec\Imrei\AddRest\Components;

use Imrei\AddRest\Components\Request;
use PhpSpec\ObjectBehavior;

class RequestSpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedWith([], []);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Request::class);
    }

    function it_has_default_values()
    {
        $this->getHttpMethod()->shouldReturn('GET');
        $this->getPathInfo()->shouldReturn('/');
        $this->getHttpGetParam('none')->shouldReturn(null);
    }

    function it_can_handle_request_method()
    {
        $this->beConstructedWith(['REQUEST_METHOD' => 'PUT'], []);
        $this->getHttpMethod()->shouldReturn('PUT');
    }

    function it_can_handle_path_info()
    {
        $this->beConstructedWith(['PATH_INFO' => '/foo/bar/baz'], []);
        $this->getPathInfo()->shouldReturn('/foo/bar/baz');
    }

    function it_can_handle_get_parameters()
    {
        $this->beConstructedWith(
            [],
            [
                'foo' => 12,
                'bar' => 23,
            ]
        );
        $this->getHttpGetParam('foo')->shouldReturn(12);
        $this->getHttpGetParam('bar')->shouldReturn(23);
    }
}
