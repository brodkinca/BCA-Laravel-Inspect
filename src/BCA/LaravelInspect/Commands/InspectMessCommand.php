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

/**
 * Run PHPMD on Laravel application.
 */
class InspectMessCommand extends Inspect
{
    /**
     * Name of CLI executable.
     *
     * @var string
     * @since 1.0.1
     */
    const CLI_TOOL = 'phpmd';

    /**
     * The console command name.
     *
     * @var string
     * @since 1.0.0
     */
    protected $name = 'inspect:mess';

    /**
     * The console command description.
     *
     * @var string
     * @since 1.0.0
     */
    protected $description = 'Run PHP Mess Detector.';

    /**
     * Constructor.
     *
     * @since 1.0.2
     */
    public function __construct()
    {
        parent::__construct();

        $this->setPaths();
    }

    /**
     * Run the command. Executed immediately.
     *
     * @since 1.0.0
     *
     * @return int CLI tool exit code.
     */
    public function fire()
    {
        parent::fire();

        if ($this->option('install-ruleset')) {
            if ($this->installRuleset()) {
                $this->info('Copied ruleset to '.$this->pathRulesetLocal);
            }
        }

        $this->info('Runing PHP Mess Detector...');

        $command = $this->pathCli.' ';
        $command.= base_path().'/'.$this->option('path').' ';
        $command.= 'text ';
        $command.= $this->pathRuleset;

        passthru($command, $exitCode);

        $this->info('Done.');

        return $exitCode;
    }
}
