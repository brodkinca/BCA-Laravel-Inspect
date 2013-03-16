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
 * Artisan Inspect:Lint Command
 *
 * @category  Command
 * @package   Laravel
 */
class InspectLintCommand extends Inspect
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'inspect:lint';

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
        $this->info('Running PHP\'s built-in linter...');

        $path = base_path().'/'.$this->option('path');

        $command = 'find '.$path.' -name \'*.php\' -print0 | xargs -0 -n1 -P10 php -l';

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
            array('path', null, InputOption::VALUE_OPTIONAL, 'Path containing the files to be fixed.', 'app')
        );
    }
}
