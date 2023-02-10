<?php
/**
 * To manage seperate route service provider for Web & Api
 *
 * @name       RouteServiceProvider
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Admin\Http\Controllers';
    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map() {
        $this->mapApiRoutes ();
        $this->mapWebRoutes ();
    }
    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes() {
        Route::group ( [ 
                'middleware' => 'web',
                'namespace' => 'Admin\Http\Controllers\Web' 
        ], function () {
            require base_path ( 'routes/web.php' );
        } );
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes() {
        if($this->isMobile()){
            auth()->shouldUse('mobile_users');
         }
        Route::group ( [ 
                'middleware' => 'api',
                'namespace' => 'Admin\Http\Controllers\Api',
                'prefix' => 'api' 
        ], function () {
            require base_path ( 'routes/api.php' );
        } );
    }
    /**
     * Check current request is for Mobile APP
     *
     * @return bool
     */
    private function isMobile(){
       $isMobileApp = false;
       if (!is_null(app()->make('request')->header('X-REQUEST-TYPE')) && app()->make('request')->header('X-REQUEST-TYPE') == 'mobile') {
           $isMobileApp = true;
       }
       return $isMobileApp;
   }
}
