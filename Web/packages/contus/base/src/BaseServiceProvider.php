<?php
/**
 * Base service provider for Web & Api
 *
 * @name       BaseServiceProvider
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Base;

use Illuminate\Support\ServiceProvider;
use Contus\Base\Lib\ResourceRegistrar;
use Illuminate\Routing\ResourceRegistrar as BaseResourceRegistrar;

class BaseServiceProvider extends ServiceProvider {
    /**
     * Boot method of service provider
     * add upload controller route
     *
     * @return void
     */
    public function boot() {
        $this->app['router']->post(
            'api/upload',
            'Contus\Base\Controllers\Api\UploadController@handleUpload'
        );

        $this->loadTranslationsFrom(__DIR__.DIRECTORY_SEPARATOR.'lang', 'base');
    }    
    /**
     * Register method of service provider 
     * custom ResourceRegistrar for adding action method to the resource
     * publish options for moving asserts to public path
     *
     * @return void
     */
    public function register() {
        $this->publishes([__DIR__.DIRECTORY_SEPARATOR.'assets/js' => base_path().'/public/assets/js/modules/base'], 'base_assets');

        $this->app->bind(BaseResourceRegistrar::class, function (){
            return new ResourceRegistrar($this->app['router']);
        });
    }    
}
