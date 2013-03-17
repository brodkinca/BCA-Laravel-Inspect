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
 * Artisan Inspect:Sniff Command
 *
 * @category  Command
 * @package   Laravel
 */
class InspectSniffCommand extends Inspect
{
    /**
     * Name of CLI executable
     *
     * @var string
     */
    const CLI_TOOL = 'phpcs';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'inspect:sniff';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run PHP Code Sniffer.';

    /**
     * Run the command. Executed immediately.
     *
     * @return void
     */
    public function fire()
    {
        $this->info('Running PHP Code Sniffer...');

        $this->setPaths();

        $command = $this->pathCli.' ';
        $command.= '--standard='.$this->pathRuleset.' ';
        $command.= '--tab-width=4 '; // Laravel likes tabs, phpcs doesn't
        $command.= base_path().'/'.$this->option('path');

        passthru($command);

        $this->info('Done.');
    }
}
