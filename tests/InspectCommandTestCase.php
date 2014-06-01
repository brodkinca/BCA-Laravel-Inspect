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
     * Test that rulesets are installed successfully
     *
     * @since 1.0.2
     *
     * @return void
     */
    public function testInstallRuleset()
    {
        // Instantiate class
        $class = new $this->testClass();

        // Get ruleset paths
        $pathRulesetLocal = $this->getProperty('pathRulesetLocal')->getValue($class);
        $pathRulesetStock = $this->getProperty('pathRulesetStock')->getValue($class);

        // If this command uses a ruleset...
        if ($pathRulesetStock !== null) {

            // Reflect protected mathod
            $method = $this->getMethod('installRuleset');

            // Remove local ruleset, if exists
            @unlink($pathRulesetLocal);

            $this->assertThat($pathRulesetStock, $this->fileExists());
            $this->assertThat(
                $pathRulesetLocal,
                $this->logicalNot($this->fileExists())
            );

            $action = $method->invoke($class);
            $this->assertThat($action, $this->isTrue());

            $this->assertThat($pathRulesetLocal, $this->fileExists());
            $this->assertXmlFileEqualsXmlFile($pathRulesetLocal, $pathRulesetStock);

            // Remove local ruleset
            @unlink($pathRulesetLocal);
        }
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

        $properties[] = $this->getProperty('pathCli');
        $properties[] = $this->getProperty('pathRuleset');
        $properties[] = $this->getProperty('pathRulesetStock');

        foreach ($properties as $property) {
            $this->assertThat($property->isProtected(), $this->isTrue());
            $this->assertThat($property->getValue($class), $this->fileExists());
        }

        $propertyRulesetLocal = $this->getProperty('pathRulesetLocal');
        $this->assertThat($propertyRulesetLocal->isProtected(), $this->isTrue());
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
                $this->assertThat(
                    $option[4],
                    $this->logicalOr(
                        $this->isType('string'),
                        $this->isType('int')
                    )
                );
            }
        }
    }
}
