<?php
/**
 * Resource Registrar
 *
 * To add a new resource method to the laravel Resource Controller 
 *
 * @name       ResourceRegistrar
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Base\Lib;

use Illuminate\Routing\ResourceRegistrar as BaseResourceRegistrar;

class ResourceRegistrar extends BaseResourceRegistrar {
    /**
     * The default actions for a resourceful controller.
     *
     * @var array
     */
    protected $resourceDefaults = [ 
            'index',
            'create',
            'store',
            'show',
            'edit',
            'update',
            'destroy',
            'action' 
    ];
    /**
     * Add the action method for a resourceful route.
     *
     * @param string $name            
     * @param string $base            
     * @param string $controller            
     * @param array $options            
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceAction($name, $base, $controller, $options) {
        return $this->router->post ( $this->getResourceUri ( $name ) . '/action', $this->getResourceAction ( $name, $controller, 'action', $options ) );
    }
    /**
     * Add the destroy method for a resourceful route.
     *
     * @param string $name            
     * @param string $base            
     * @param string $controller            
     * @param array $options            
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceDestroy($name, $base, $controller, $options) {        
        return $this->router->delete ($this->getResourceUri ( $name ) . '/destroy', $this->getResourceAction ( $name, $controller, 'destroy', $options ));
    }
}