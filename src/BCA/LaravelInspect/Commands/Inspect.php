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

namespace BCA\LaravelInspect\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

/**
 * Abstract class for executing code quality tools.
 *
 * @category   Command
 * @package    Laravel
 * @subpackage Artisan
 */
abstract class Inspect extends Command
{
    /**
     * Name of CLI executable.
     *
     * @var string
     * @since 1.0.1
     */
    const CLI_TOOL = '';

    /**
     * Path to CLI tool being executed.
     *
     * @var string
     * @since 1.0.1
     */
    protected $pathCli;

    /**
     * Path to ruleset for this tool.
     *
     * @var string
     * @since 1.0.1
     */
    protected $pathRuleset;

    /**
     * Potential path to local ruleset for this tool.
     *
     * @var string
     * @since 1.0.2
     */
    protected $pathRulesetLocal;

    /**
     * Path to stock ruleset for this tool.
     *
     * @var string
     * @since 1.0.2
     */
    protected $pathRulesetStock;

    /**
     * Executes the command.
     *
     * @since  1.0.2
     *
     * @return void
     */
    public function fire()
    {
        // Notify user if using local ruleset.
        if ($this->pathRulesetLocal !== null
            && is_readable($this->pathRulesetLocal)
        ) {
            $this->info(
                'Local ruleset file found. Default ruleset will be ignored.'
            );
        }
    }

    /**
     * Get the console command options.
     *
     * @since 1.0.0
     *
     * @return array
     */
    protected function getOptions()
    {
        // Allow path to be overridden.
        $options[] = array(
            'path',
            null,
            InputOption::VALUE_OPTIONAL,
            'Path containing the files to be inspected.',
            'app'
        );

        // Offer to install the ruleset locally if available.
        $this->setPaths();
        if ($this->pathRulesetStock !== null) {
            $options[] = array(
                'install-ruleset',
                null,
                InputOption::VALUE_NONE,
                'Copy our ruleset into your project.'
            );
        }

        return $options;
    }

    /**
     * Install ruleset in base path.
     *
     * @since 1.0.2
     *
     * @return boolean
     */
    protected function installRuleset()
    {
        if (!file_exists($this->pathRulesetLocal)
            || $this->confirm('Overwrite local configuration with our copy? (y/n) [y]')
        ) {
            $copy = copy($this->pathRulesetStock, $this->pathRulesetLocal);

            return $copy;
        }

        return false;
    }

    /**
     * Check if CLI tool is installed.
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
     * Set paths to executable and ruleset.
     *
     * @since  1.0.1
     *
     * @return void
     */
    protected function setPaths()
    {
        $pathPackage = realpath(__DIR__.'/../../../../');
        $pathBase = realpath(base_path());

        // Set CLI path.
        $this->pathCli = $pathBase.'/vendor/bin/'.$this::CLI_TOOL;
        if (!file_exists($this->pathCli)) {
            $this->pathCli = $pathPackage.'/vendor/bin/'.$this::CLI_TOOL;
        }

        // Set ruleset paths.
        $this->pathRulesetStock = $pathPackage.'/rulesets/'.$this::CLI_TOOL.'.xml';
        $this->pathRulesetLocal = $pathBase.'/'.$this::CLI_TOOL.'.xml';
        $this->pathRulesetLocalLegacy = $pathBase.'/app/'.$this::CLI_TOOL.'.xml';

        // Set active ruleset.
        $this->pathRuleset = $this->pathRulesetStock;
        if (is_readable($this->pathRulesetLocal)) {
            $this->pathRuleset = $this->pathRulesetLocal;
        } elseif (is_readable($this->pathRulesetLocalLegacy)) {
            $this->pathRuleset = $this->pathRulesetLocalLegacy;
        }
    }
}
