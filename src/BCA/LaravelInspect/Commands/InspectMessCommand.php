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

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Run PHPMD on Laravel application.
 */
class InspectMessCommand extends Inspect
{
    /**
     * Name of CLI executable.
     *
     * @var string
     * @since 1.0.1
     */
    const CLI_TOOL = 'phpmd';

    /**
     * The console command name.
     *
     * @var string
     * @since 1.0.0
     */
    protected $name = 'inspect:mess';

    /**
     * The console command description.
     *
     * @var string
     * @since 1.0.0
     */
    protected $description = 'Run PHP Mess Detector.';

    /**
     * The available command options.
     *
     * @var array
     * @since 1.4.0
     */
    protected $options = array(
        'report-file',
    );

    /**
     * Constructor.
     *
     * @since 1.0.2
     */
    public function __construct()
    {
        parent::__construct();

        $this->setPaths();
    }

    /**
     * Get the console command arguments.
     *
     * @since 1.4.0
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array(
                'format',
                InputArgument::OPTIONAL,
                'Report format. Available formats: xml, text, html.',
                'text',
            ),
        );
    }

    /**
     * Get the console command options.
     *
     * @since 1.4.0
     *
     * @return array
     */
    protected function getOptions()
    {
        $options = parent::getOptions();

        // Add --reportfile option.
        $options[] = array(
            'report-file',
            null,
            InputOption::VALUE_REQUIRED,
            'Send the report output to the specified file path. Default to STDOUT',
        );

        return $options;
    }

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

        if ($this->option('install-ruleset')) {
            if ($this->installRuleset()) {
                $this->info('Copied ruleset to '.$this->pathRulesetLocal);
            }
        }

        $this->info('Runing PHP Mess Detector...');

        $commandParts = array(
            $this->pathCli,
            base_path($this->option('path')),
            $this->argument('format'),
            $this->pathRuleset,
        );

        $commandParts = $this->appendCommandOptions($commandParts);

        $command = implode(' ', $commandParts);

        passthru($command, $exitCode);

        $this->info('Done.');

        return $exitCode;
    }

    /**
     * Append options to CLI command.
     *
     * @param array $commandParts Array of command parts as strings.
     *
     * @since 1.4.0
     *
     * @return array
     */
    protected function appendCommandOptions(array $commandParts)
    {
        foreach ($this->options as $optionKey) {
            // We want to preserve report-file option consistend with inspect:sniff
            if ($optionKey == 'report-file') {
                $optionValue = $this->option($optionKey);
                if (!empty($optionValue)) {
                    $this->info(sprintf('Generating report into file "%s".', $optionValue));
                    $commandParts[] = sprintf('--reportfile %s', $optionValue);
                }
            }
        }

        return $commandParts;
    }
}
