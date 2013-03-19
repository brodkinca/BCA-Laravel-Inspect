<?php

/**
 * Inspector Tools for Artisan
 *
 * PHP Version 5.3
 *
 * @category   Command
 * @package    Laravel
 * @subpackage Artisan
 * @author     Brodkin CyberArts <oss@brodkinca.com>
 * @copyright  2013 Brodkin CyberArts.
 * @license    MIT
 * @version    GIT: $Id$
 * @link       https://github.com/brodkinca/BCA-Laravel-Inspect
 */

namespace BCA\LaravelInspect\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

/**
 * Artisan Inspect Abstract Class
 *
 * @category   Command
 * @package    Laravel
 * @subpackage Artisan
 */
abstract class Inspect extends Command
{
    /**
     * Name of CLI executable
     *
     * @since 1.0.1
     *
     * @var string
     */
    const CLI_TOOL = '';

    /**
     * Path to CLI tool being executed
     *
     * @since 1.0.1
     *
     * @var string
     */
    protected $pathCli;

    /**
     * Path to ruleset for this tool
     *
     * @since 1.0.1
     *
     * @var string
     */
    protected $pathRuleset;

    /**
     * Executes the command
     *
     * @return void
     */
    abstract public function fire();

    /**
     * Get the console command options.
     *
     * @since 1.0.0
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('path', null, InputOption::VALUE_OPTIONAL, 'Path containing the files to be inspected.', 'app')
        );
    }

    /**
     * Is CLI tool installed?
     *
     * @since 1.0.1
     *
     * @return boolean
     */
    protected function isInstalledGlobally()
    {
        $which = exec('which '.$this::CLI_TOOL);

        if (file_exists($which)) {
            return true;
        }

        return false;
    }

    /**
     * Set paths to executable and ruleset
     *
     * @since  1.0.1
     *
     * @return void
     */
    protected function setPaths()
    {
        $pathPackage = realpath(__DIR__.'/../../../../');

        // Path to CLI tool
        $this->pathCli = $pathPackage.'/vendor/bin/'.$this::CLI_TOOL;

        // Check for a local ruleset
        $this->pathRuleset = $pathPackage.'/rulesets/'.$this::CLI_TOOL.'.xml';
        if (is_readable(base_path().'/'.$this::CLI_TOOL.'.xml')) {
            $this->pathRuleset = realpath(base_path().'/'.$this::CLI_TOOL.'.xml');
        }
    }
}
