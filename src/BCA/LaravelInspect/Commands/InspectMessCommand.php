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
 * @license   All rights reserved.
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

        $command = realpath(__DIR__.'/../../../../vendor/bin/phpmd');
        $command.= ' ';
        $command.= base_path().'/'.$this->option('path');
        $command.= ' text ';

        // Check for a local ruleset
        $ruleset = realpath(__DIR__.'/../../../../rulesets/phpmd.xml').' ';
        if (is_readable(base_path().'/phpmd.xml')) {
            $ruleset = realpath(base_path().'/phpmd.xml').' ';
        }
        $command.= $ruleset;

        passthru($command);

        $this->info('Done.');
    }
}
