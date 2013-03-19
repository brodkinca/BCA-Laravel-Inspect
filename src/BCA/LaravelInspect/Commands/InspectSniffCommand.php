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
 * Artisan Inspect:Sniff Command
 *
 * @category   Command
 * @package    Laravel
 * @subpackage Artisan
 */
class InspectSniffCommand extends Inspect
{
    /**
     * Name of CLI executable
     *
     * @since 1.0.1
     *
     * @var string
     */
    const CLI_TOOL = 'phpcs';

    /**
     * The console command name.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $name = 'inspect:sniff';

    /**
     * The console command description.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $description = 'Run PHP Code Sniffer.';

    /**
     * Constructor
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
     * @return void
     */
    public function fire()
    {
        $this->info('Running PHP Code Sniffer...');

        $command = $this->pathCli.' ';
        $command.= '--standard='.$this->pathRuleset.' ';
        $command.= '--tab-width=4 '; // Laravel likes tabs, phpcs doesn't
        $command.= base_path().'/'.$this->option('path');

        passthru($command);

        $this->info('Done.');
    }
}
