<?php
/**
 * Inspector Tools for Artisan
 *
 * @category  ServiceProvider
 * @package   bca/laravel-inspect
 * @author    Brodkin CyberArts <info@brodkinca.com>
 * @copyright 2013-2014 Brodkin CyberArts
 * @license   MIT
 * @version   GIT: $Id$
 * @link      https://github.com/brodkinca/BCA-Laravel-Inspect
 */

namespace BCA\LaravelInspect\Tests;

use BCA\LaravelInspect\LaravelInspectServiceProvider as ServiceProvider;
use \ReflectionClass as RC;

/**
 * Test service provider.
 */
class LaravelInspectServiceProviderTest extends InspectTestCase
{

    /**
     * Fully namespaced identifier for class to be tested.
     *
     * @var string
     * @since 1.0.1
     */
    protected $testClass = 'BCA\LaravelInspect\LaravelInspectServiceProvider';

    /**
     * Test that command has Command as a parent.
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
     * Verify deferred loading is disabled.
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
