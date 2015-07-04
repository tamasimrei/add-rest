<?php
/**
 * This source file is copyrighted by Tamas Imrei <tamas.imrei@gmail.com>.
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */
namespace Imrei\AddRest\Tests\View;

use Imrei\AddRest\View\JSONView;
use Imrei\AddRest\Helpers\ReflectionHelper;

class JSONViewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Testing that the view's render method return valid JSON containing
     * the data passed in
     *
     * @dataProvider getJSONTestData
     */
    public function testRender($data)
    {
        $view = new JSONView();
        $rendered = $view->render($data);
        $decoded = json_decode($rendered, true);
        $this->assertEquals($data, $decoded);
    }

    /**
     * Data provider for testing the render method
     *
     * @return array
     */
    public function getJSONTestData()
    {
        return [
            [ 123456 ],
            ["simple string"],
            [["foo" => 1, "bar" => "baz"]],
            [ true ],
            [ false ],
            [ null ]
        ];
    }

    /**
     * Test if the set content type is returned by the getter
     */
    public function testGetContentType()
    {
        $view = new JSONView();
        $contentType = ReflectionHelper::getProtectedPropertyValue($view, 'contentType');
        $this->assertEquals($contentType, $view->getContentType());
    }
}
