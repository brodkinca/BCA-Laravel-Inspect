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

namespace BCA\LaravelInspect;

use Illuminate\Support\ServiceProvider;

/**
 * Instantiate Artisan inspect command.
 */
class LaravelInspectServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var boolean
     * @since 1.0.0
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @since 1.0.0
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
     * @since 1.0.0
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
     * @since 1.0.0
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
