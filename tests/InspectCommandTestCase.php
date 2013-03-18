<?php

namespace BCA\LaravelInspect\Tests;

use \ReflectionClass as RC;

abstract class InspectCommandTestCase extends InspectTestCase
{
    /**
     * Fully namespaced identifier for class to be tested.
     *
     * @since 1.0.1
     * @var   string
     */
    protected $testClass = '';

    /**
     * Test that command has Command as a parent
     *
     * @since 1.0.1
     *
     * @return void
     */
    public function testSublassOfCommand()
    {
        $class = new RC($this->testClass);
        $this->assertThat(
            $class->isSubclassOf('Illuminate\Console\Command'),
            $this->isTrue()
        );
    }

    /**
     * Test that directory paths are set and valid
     *
     * @since 1.0.1
     *
     * @return void
     */
    public function testSetPaths()
    {
        $class = new $this->testClass();
        $class->setPaths();

        $properties[] = $this->getProperty('pathCli');
        $properties[] = $this->getProperty('pathRuleset');

        foreach ($properties as $property) {
            $this->assertThat($property->isProtected(), $this->isTrue());
            $this->assertThat($property->getValue($class), $this->fileExists());
        }
    }

    /**
     * Test getOptions return values
     *
     * Asserts that all values are acceptable types.
     *
     * @since 1.0.1
     *
     * @return void
     */
    final public function testGetOptions()
    {
        $class = new $this->testClass();

        $getOptionsMethod = $this->getMethod('getOptions');
        $data = $getOptionsMethod->invoke($class);

        foreach ($data as $option) {
            $this->assertInternalType('string', $option[0]);
            $this->assertThat(
                $option[1],
                $this->logicalOr(
                    $this->isType('string'),
                    $this->isType('null')
                )
            );
            $this->assertInternalType('int', $option[2]);
            $this->assertInternalType('string', $option[3]);
            if (isset($option[4])) {
                $this->assertInternalType('string', $option[4]);
            }
        }
    }
}
