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
 * Run PHP_CodeSniffer on Laravel application.
 */
class InspectSniffCommand extends Inspect
{
    /**
     * Name of CLI executable.
     *
     * @var string
     * @since 1.0.1
     */
    const CLI_TOOL = 'phpcs';

    /**
     * The console command name.
     *
     * @var string
     * @since 1.0.0
     */
    protected $name = 'inspect:sniff';

    /**
     * The console command description.
     *
     * @var string
     * @since 1.0.0
     */
    protected $description = 'Run PHP Code Sniffer.';

    /**
     * The available command options.
     *
     * @var array
     * @since 1.3.0
     */
    protected $options = array(
        'report',
        'report-file',
        'tab-width',
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
     * Get the console command options.
     *
     * @since 1.0.0
     *
     * @return array
     */
    protected function getOptions()
    {
        $options = parent::getOptions();

        // Add --report flag.
        $options[] = array(
            'report',
            null,
            InputOption::VALUE_REQUIRED,
            'Print either the "full", "xml", "checkstyle", "csv", "json", "emacs", "source", "summary", "svnblame",
"gitblame", "hgblame" or "notifysend" report (the "full" report is printed by default).',
        );

        // Add --report-file flag.
        $options[] = array(
            'report-file',
            null,
            InputOption::VALUE_REQUIRED,
            'Write the report to the specified file path.',
        );

        // Add --tab-width flag.
        $options[] = array(
            'tab-width',
            null,
            InputOption::VALUE_REQUIRED,
            'Set the number of spaces which should be substituted for each tab when sniffing.',
            4
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

        $this->info('Running PHP Code Sniffer...');

        $commandParts = array(
            $this->pathCli,
            '--standard='.$this->pathRuleset,
            // Laravel likes tabs, phpcs doesn't.
            sprintf('--tab-width=%d', $this->option('tab-width')),
        );

        $commandParts = $this->appendCommandOptions($commandParts);

        $commandParts[] = sprintf('%s/%s', base_path(), $this->option('path'));

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
     * @since 1.3.0
     *
     * @return array
     */
    private function appendCommandOptions(array $commandParts)
    {
        foreach ($this->options as $optionKey) {
            // Skip tab-width option because it's appended by default.
            if ($optionKey == 'tab-width') {
                continue;
            }

            $optionValue = $this->option($optionKey);
            if (!empty($optionValue)) {
                $commandParts[] = sprintf('--%s=%s', $optionKey, $optionValue);
            }
        }

        return $commandParts;
    }
}
