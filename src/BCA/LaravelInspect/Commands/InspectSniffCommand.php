<?php

/**
 * Inspector Tools for Artisan
 *
 * PHP Version 5.3
 *
 * @category  Command
 * @package   Laravel
 * @author    Brodkin CyberArts <support@brodkinca.com>
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

        // Set path to phpcs executable
        $command = realpath(__DIR__.'/../../../../vendor/bin/phpcs').' ';

        // Check for a local ruleset
        $coding_standard = realpath(__DIR__.'/../../../../rulesets/phpcs.xml').' ';
        if (is_readable(base_path().'/phpcs.xml')) {
            $coding_standard = realpath(base_path().'/phpcs.xml').' ';
        }
        $command.= '--standard='.$coding_standard;

        // Help out the folks who like tabs
        $command.= '--tab-width=4 ';

        // Set path to files to be inspected
        $command.= base_path().'/'.$this->option('path');

        passthru($command);

        $this->info('Done.');
    }
}
