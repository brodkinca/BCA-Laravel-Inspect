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

namespace BCA\LaravelInspect;

use Illuminate\Support\ServiceProvider;

/**
 * Laravel Inspect Service Provider
 *
 * @category  ServiceProvider
 * @package   Laravel
 */
class LaravelInspectServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('bca/laravel-inspect');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['inspect.fix'] = $this->app->share(
            function ($app) {
                return new Commands\InspectFixCommand($app);
            }
        );

        $this->app['inspect.sniff'] = $this->app->share(
            function ($app) {
                return new Commands\InspectSniffCommand($app);
            }
        );

        $this->app['inspect.lint'] = $this->app->share(
            function ($app) {
                return new Commands\InspectLintCommand($app);
            }
        );

        $this->app['inspect.mess'] = $this->app->share(
            function ($app) {
                return new Commands\InspectMessCommand($app);
            }
        );

        $this->commands(
            'inspect.fix',
            'inspect.sniff',
            'inspect.lint',
            'inspect.mess'
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
