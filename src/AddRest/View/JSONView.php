<?php
/**
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */
namespace Imrei\AddRest\View;

use Imrei\AddRest\View\Interfaces\Renderable;
use Imrei\AddRest\View\Interfaces\ContentTypeable;

/**
 * Simple static view class to render data into a JSON string
 */
class JSONView implements Renderable, ContentTypeable
{
    /**
     * @var string the content type of the rendered output
     */
    protected $contentType = 'application/json';

    /* (non-PHPdoc)
     * @see \Imrei\AddRest\View\Interfaces\ContentTypeable::getContentType
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /* (non-PHPdoc)
     * @see \Imrei\AddRest\View\Interfaces\Renderable::render()
     */
    public function render($data)
    {
        return json_encode($data);
    }
}
