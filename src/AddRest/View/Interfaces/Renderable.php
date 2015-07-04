<?php
/**
 * This source file is copyrighted by Tamas Imrei <tamas.imrei@gmail.com>.
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */
namespace Imrei\AddRest\View\Interfaces;

/**
 * Simple interface used to convert a mixed PHP variable value to a string
 */
interface Renderable
{
    /**
     * Represent mixed PHP variables in a specific format, e.g. JSON or XML or HTML
     *
     * @param mixed $data input data to be rendered
     * @return string the rendered string
     */
    public function render($data);
}
