<?php

namespace BCA\LaravelInspect\Tests;

use BCA\LaravelInspect\LaravelInspectServiceProvider as ServiceProvider;
use \ReflectionClass as RC;

class LaravelInspectServiceProviderTest extends InspectTestCase
{
    /**
     * Fully namespaced identifier for class to be tested.
     *
     * @since 1.0.1
     * @var   string
     */
    protected $testClass = 'BCA\LaravelInspect\LaravelInspectServiceProvider';

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
            $class->isSubclassOf('Illuminate\Support\ServiceProvider'),
            $this->isTrue()
        );
    }

    /**
     * Test deferred loading is disabled
     *
     * @since 1.0.1
     *
     * @return void
     */
    public function testNotDeferred()
    {
        $properties = $this->getDefaultProperties();
        $this->assertThat(isset($properties['defer']), $this->isTrue());
        $this->assertThat($properties['defer'], $this->isFalse());

        $property = $this->getProperty('defer');
        $this->assertThat($property->isProtected(), $this->isTrue());
    }
}
