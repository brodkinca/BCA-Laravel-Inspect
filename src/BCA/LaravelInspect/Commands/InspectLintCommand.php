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

use Symfony\Component\Console\Input\InputOption;

/**
 * Run native PHP linter on Laravel application.
 */
class InspectLintCommand extends Inspect
{
    /**
     * Name of CLI executable.
     *
     * @var string
     * @since 1.0.1
     */
    const CLI_TOOL = 'php';

    /**
     * The console command name.
     *
     * @var string
     * @since 1.0.0
     */
    protected $name = 'inspect:lint';

    /**
     * The console command description.
     *
     * @var string
     * @since 1.0.0
     */
    protected $description = 'Run PHP\'s built-in linter.';

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

        if (!$this->isInstalledGlobally()) {
            $this->error(
                'Cannot continue. PHP is not in your system path.'
            );

            return false;
        }

        $this->info('Running PHP\'s built-in linter...');

        $path = base_path().'/'.$this->option('path');

        $command = 'find '.$path.' -name \'*.php\' -print0 | xargs -0 -n1 -P10 php -l';

        passthru($command, $exitCode);

        $this->info('Done.');

        return $exitCode;
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
