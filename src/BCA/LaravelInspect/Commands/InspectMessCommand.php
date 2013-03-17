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

/**
 * Artisan Inspect:Mess Command
 *
 * @category   Command
 * @package    Laravel
 * @subpackage Artisan
 */
class InspectMessCommand extends Inspect
{
    /**
     * Name of CLI executable
     *
     * @since 1.0.1
     *
     * @var string
     */
    const CLI_TOOL = 'phpmd';

    /**
     * The console command name.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $name = 'inspect:mess';

    /**
     * The console command description.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $description = 'Run PHP Mess Detector.';

    /**
     * Run the command. Executed immediately.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function fire()
    {
        $this->info('Runing PHP Mess Detector...');

        $this->setPaths();

        $command = $this->pathCli.' ';
        $command.= base_path().'/'.$this->option('path').' ';
        $command.= 'text ';
        $command.= $this->pathRuleset;

        passthru($command);

        $this->info('Done.');
    }
}
