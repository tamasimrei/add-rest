<?php
/**
 * This source file is copyrighted by Tamas Imrei <tamas.imrei@gmail.com>.
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */
namespace Imrei\AddRest\View\Interfaces;

/**
 * Simple interface to determine if a view has a specific content type
 */
interface ContentTypeable
{
    /**
     * Get the Content-type of the rendered output
     *
     * @return string
     */
    public function getContentType();
}
