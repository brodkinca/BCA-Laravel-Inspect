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

/**
 * Test inspect:sniff command.
 */
class InspectSniffCommandTest extends InspectCommandTestCase
{

    /**
     * Fully namespaced identifier for class to be tested.
     *
     * @var string
     * @since 1.0.1
     */
    protected $testClass = 'BCA\LaravelInspect\Commands\InspectSniffCommand';
}
