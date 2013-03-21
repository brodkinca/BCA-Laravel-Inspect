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

use Symfony\Component\Console\Input\InputOption;

/**
 * Artisan Inspect:Lint Command
 *
 * @category   Command
 * @package    Laravel
 * @subpackage Artisan
 */
class InspectLintCommand extends Inspect
{
    /**
     * Name of CLI executable
     *
     * @since 1.0.1
     *
     * @var string
     */
    const CLI_TOOL = 'php';

    /**
     * The console command name.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $name = 'inspect:lint';

    /**
     * The console command description.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $description = 'Run PHP\'s built-in linter.';

    /**
     * Run the command. Executed immediately.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function fire()
    {
        parent::fire();

        if (!$this->isInstalledGlobally()) {
            $this->error(
                'Cannot continue. PHP is not in your system path.'
            );

            return false;
        }

        $this->info('Running PHP\'s built-in linter...');

        $path = base_path().'/'.$this->option('path');

        $command = 'find '.$path.' -name \'*.php\' -print0 | xargs -0 -n1 -P10 php -l';

        passthru($command);

        $this->info('Done.');
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
        return array(
            array('dry-run', null, InputOption::VALUE_NONE, 'Only shows which files would have been modified.'),
            array('path', null, InputOption::VALUE_OPTIONAL, 'Path containing the files to be fixed.', 'app')
        );
    }
}
