<?php

namespace BCA\LaravelInspect\Tests;

class InspectLintCommandTest extends InspectCommandTestCase
{
    /**
     * Fully namespaced identifier for class to be tested.
     *
     * @since 1.0.1
     * @var string
     */
    protected $testClass = 'BCA\LaravelInspect\Commands\InspectLintCommand';

    /**
     * Test that directory paths are set and valid
     *
     * Disabling default behavior, paths unused in this tool
     *
     * @since 1.0.1
     *
     * @return void
     */
    public function testSetPaths()
    {

    }
}
