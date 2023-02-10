<?php
/**
 * Service Provider for Router
 *
 * @name       RouterServiceProvider
 * @package    Router
 * @version    1.0
 * @author     Contus<developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Router;

use Contus\Router\LogContainer;
use Illuminate\Support\ServiceProvider;
use Contus\Router\Middleware\AfterResponse;
use Contus\Router\Console\DispatchToQueueCommand;

class BaseServiceProvider extends ServiceProvider{
    /**
     * Register the Router instance to Applicaton Container
     * Set the common middleware
     *
     * @return void
     */
    public function register(){
        $this->app->singleton('contus.router', function ($app) {
            return new RouteManager($app);
        });

        $this->app['router']->pushMiddlewareToGroup('api',AfterResponse::class);        

        $this->registerRouterLogger();

        $this->registerCustomQueueProvider();

        $this->registerRouterDispatch();

        $this->registerDispatchToQueueCommand();
    }
    /**
     * Register the router logger with the application container.
     *
     * @return void
     */
    public function registerRouterLogger(){
        $this->app->make('config')->set('database.connections.loggersql',[
            'driver' => env('ROUTERLOGGER_DB_CONNECTION','mysql'),
            'host' => env('ROUTERLOGGER_DB_HOST','localhost'),
            'port' => env('ROUTERLOGGER_DB_PORT','3306'),
            'database' => env('ROUTERLOGGER_DB_DATABASE','moverbee_logger'),
            'username' => env('ROUTERLOGGER_DB_USERNAME','root'),
            'password' => env('ROUTERLOGGER_DB_PASSWORD','root'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci'                
        ]);

        $this->app->singleton('contus.router.logger', function ($app) {
            return new LogContainer($app->make('log'));
        });
    }
    /**
     * Register the custom queue provider with the application container.
     * here available container bindings also removed
     *
     * @return void
     */
    public function registerCustomQueueProvider(){
        $this->app->register(QueueServiceProvider::class);
    }
    /**
     * Register the router dispatcher
     * shared with application so the necessary data is dispatched to 
     * the queue when ever required
     *
     * @return void
     */
    public function registerRouterDispatch(){
        $this->app->singleton('contus.router.dispatcher', function ($app) {
            return new Dispatcher($app->make('contus.router.logger'));
        });
    }
    /**
     * Register the custom queue dispatch command
     * to provide convinence while accessing the application from CLI
     *
     * @return void
     */
    public function registerDispatchToQueueCommand(){
        $this->app->singleton('command.router.dispatch', function ($app) {
            return new DispatchToQueueCommand();
        });

        $this->commands('command.router.dispatch');
    }                
}
