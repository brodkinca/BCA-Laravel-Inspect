<?php

namespace BCA\LaravelInspect\Tests;

use \ReflectionClass as RC;
use \TestCase;

abstract class InspectTestCase extends TestCase
{
    /**
     * Get reflection method from the command class
     *
     * @param string $name Name of property
     * @since 1.0.1
     *
     * @return ReflectionMethod
     */
    protected function getMethod($name)
    {
        $class = new RC($this->testClass);
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }

    /**
     * Get reflection property from the command class
     *
     * @param string $name Name of property
     * @since 1.0.1
     *
     * @return ReflectionProperty
     */
    protected function getProperty($name)
    {
        $class = new RC($this->testClass);
        $property = $class->getProperty($name);
        $property->setAccessible(true);

        return $property;
    }

    /**
     * Get default values of all properties via reflection
     *
     * @since 1.0.1
     *
     * @return array
     */
    protected function getDefaultProperties()
    {
        $class = new RC($this->testClass);
        $properties = $class->getDefaultProperties();

        return $properties;
    }
}
