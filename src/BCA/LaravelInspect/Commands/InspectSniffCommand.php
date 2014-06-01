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
     * The available command options.
     *
     * @since 1.3.0
     *
     * @var array
     */
    protected $availableCommandOptions = array(
        'report',
        'report-file',
        'tab-width',
    );

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
     * Get the console command options.
     *
     * @since 1.0.0
     *
     * @return array
     */
    protected function getOptions()
    {
        $options = parent::getOptions();

        // --report
        $options[] = array(
            'report',
            null,
            InputOption::VALUE_REQUIRED,
            'Print either the "full", "xml", "checkstyle", "csv", "json", "emacs", "source", "summary", "svnblame",
"gitblame", "hgblame" or "notifysend" report (the "full" report is printed by default).',
        );

        // --report-file
        $options[] = array(
            'report-file',
            null,
            InputOption::VALUE_REQUIRED,
            'Write the report to the specified file path.',
        );

        // --tab-width
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
     * @return void
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
            sprintf('--tab-width=%d', $this->option('tab-width')), // Laravel likes tabs, phpcs doesn't
        );

        $this->appendCommandOptions($commandParts);

        $commandParts[] = sprintf('%s/%s', base_path(), $this->option('path'));

        $command = implode(' ', $commandParts);
        passthru($command);

        $this->info('Done.');
    }

    /**
     * Append Options to CLI Command
     *
     * @param Array $commandParts
     *
     * @since 1.3.0
     *
     * @return Array
     */
    private function appendCommandOptions(Array &$commandParts)
    {
        foreach ($this->availableCommandOptions as $optionKey) {
            // Skip tab-width option because it's appended by default
            if ($optionKey == 'tab-width') {
                continue;
            }

            $optionValue = $this->option($optionKey);
            if (!empty($optionValue)) {
                $commandParts[] = sprintf('--%s=%s', $optionKey, $optionValue);
            }
        }
    }
}
