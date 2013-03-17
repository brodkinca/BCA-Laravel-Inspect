<?php

/**
 * Inspector Tools for Artisan
 *
 * PHP Version 5.3
 *
 * @category  Command
 * @package   Laravel
 * @author    Brodkin CyberArts <oss@brodkinca.com>
 * @copyright 2013 Brodkin CyberArts.
 * @license   MIT
 * @version   GIT: $Id$
 * @link      https://github.com/brodkinca/BCA-Laravel-Inspect
 */

namespace BCA\LaravelInspect\Commands;

/**
 * Artisan Inspect:Mess Command
 *
 * @category  Command
 * @package   Laravel
 */
class InspectMessCommand extends Inspect
{
    /**
     * Name of CLI executable
     *
     * @var string
     */
    const CLI_TOOL = 'phpmd';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'inspect:mess';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run PHP Mess Detector.';

    /**
     * Run the command. Executed immediately.
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
