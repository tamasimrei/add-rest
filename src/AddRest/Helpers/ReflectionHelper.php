<?php

/**
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */

namespace Imrei\AddRest\Helpers;

/**
 * Static helper class for using Reflection classes
 */
class ReflectionHelper
{
    /**
     * Static method to access a protected property within an object
     *
     * @param object $object to access the property in
     * @param string $propertyName name of the property to modify
     * @return \ReflectionProperty
     */
    public static function getProtectedProperty($object, $propertyName)
    {
        $propertyReflection = new \ReflectionProperty($object, $propertyName);
        $propertyReflection->setAccessible(true);
        return $propertyReflection;
    }

    /**
     * Static method to set the value of a protected property within an object
     *
     * @param object $object to set the property in
     * @param string $propertyName name of the property to modify
     * @param mixed $value to set
     */
    public static function setProtectedPropertyValue($object, $propertyName, $value)
    {
        $propertyReflection = static::getProtectedProperty($object, $propertyName);
        $propertyReflection->setValue($object, $value);
    }

    /**
     * Static method to get the value of a protected property within an object
     *
     * @param object $object to get the property from
     * @param string $propertyName name of the property which value to return
     * @return mixed
     */
    public static function getProtectedPropertyValue($object, $propertyName)
    {
        $propertyReflection = static::getProtectedProperty($object, $propertyName);
        return $propertyReflection->getValue($object);
    }
}
