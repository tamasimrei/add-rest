<?php
/**
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */
namespace Imrei\AddRest\Components;

use Imrei\AddRest\Exceptions\Components\ContainerException;

/**
 * Simple dependency injection container storing literal values and callables
 */
class Container
{
    /**
     * @var array storing callables dependency items
     */
    protected $items = array();

    /**
     * @var array storing callables for reusable objects
     */
    protected $reusables = array();

    /**
     * Save a closure in the container
     *
     * @param string $name
     * @param mixed $closure a literal value or a callable
     */
    public function set($name, $closure)
    {
        $this->items[$name] = $closure;
    }

    /**
     * Save a closure for re-use in the container
     *
     * @param string $name
     * @param callable $closure
     */
    public function setReusable($name, callable $closure)
    {
        $this->reusables[$name] = $closure;
    }

    /**
     * Get an item from the container by name
     *
     * @param string $name
     * @return mixed literal value or the result of a callable
     * @throws ContainerException
     */
    public function get($name)
    {
        // Item already stored
        if (array_key_exists($name, $this->items)) {
            // It's a closure
            if (is_callable($this->items[$name])) {
                return call_user_func($this->items[$name], $this);
            }

            // Or, it's a raw value
            return $this->items[$name];
        }

        // Item is a reusable
        if (array_key_exists($name, $this->reusables)) {
            $reusable = call_user_func($this->reusables[$name], $this);
            $this->items[$name] = $reusable;
            return $reusable;
        }

        // Item not found
        throw new ContainerException('Invalid slot name specified');
    }
}
