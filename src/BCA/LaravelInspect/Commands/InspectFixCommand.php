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

use Symfony\Component\Console\Input\InputOption;

/**
 * Artisan Inspect:Fix Command
 *
 * @category  Command
 * @package   Laravel
 */
class InspectFixCommand extends Inspect
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'inspect:fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run PHP-CS-Fixer.';

    /**
     * Run the command. Executed immediately.
     *
     * @return void
     */
    public function fire()
    {
        $this->info('Running php-cs-fixer...');

        if (!$this->option('dry-run') && !$this->option('force')) {
            if (
                !$this->confirm(
                    'This will permanently modify your code to comply with PSR-1. '."\n".
                    'Are you sure that you want to continue? (y/n)[y]'
                )
            ) {
                return false;
            }
        }

        $command = realpath(__DIR__.'/../../../../vendor/bin/php-cs-fixer');
        $command.= ' fix ';
        $command.= base_path().'/'.$this->option('path');
        $command.= ' --level=psr1';
        if ($this->option('dry-run')) {
            $command.= ' --dry-run';
        }

        passthru($command);

        $this->info('Done.');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('dry-run', null, InputOption::VALUE_NONE, 'Only shows which files would have been modified.'),
            array('force', 'f', InputOption::VALUE_NONE, 'Do not confirm before editing files.'),
            array('path', null, InputOption::VALUE_OPTIONAL, 'Path containing the files to be fixed.', 'app')
        );
    }
}
