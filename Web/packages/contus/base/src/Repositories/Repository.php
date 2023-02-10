<?php
/**
 * Admin Base Repository
 *
 * To manage admin related actions.
 *
 * @name       Repository
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Base\Repositories;

use BadMethodCallException;
use Illuminate\Http\Request;
use Contus\Base\Traits\ResponseHandler;
use Contus\Base\Traits\GridHandler;
use Contus\Base\Traits\ResourceHandler;
use Contus\Base\Traits\ValidationHandler;
use Illuminate\Database\Eloquent\Model;
use Contus\Base\Contracts\GridableInterface;
use Contus\Base\Contracts\ResourceInterface;

abstract class Repository implements GridableInterface,ResourceInterface {
    use ValidationHandler,GridHandler,ResourceHandler,ResponseHandler;
    /**
     * The request registered on Base Repository.
     *
     * @var object
     */
    protected $request;
    /**
     * The auth registered on Base Repository.
     *
     * @var object
     */
    protected $auth;
    /**
     * The authenticated user model.
     *
     * @var object
     */
    protected $authUser = null;
    /**
     * The class property to hold the logger object
     *
     * @var object
     */
    protected $logger;     
    /**
     * Class constants for holding various request type handled repositories
     * 
     * @var const
     */
    const REQUEST_TYPE_API = 'API';
    const REQUEST_TYPE_HTTP = 'HTTP';
    /**
     * Class property for holding various request type handled repositories
     * 
     * @var array
     */
    protected $requestTypes = [ 
        self::REQUEST_TYPE_HTTP,
        self::REQUEST_TYPE_API 
    ];
    /**
     * Class property to hold the request type
     *
     * @var string
     */
    protected $requestType = self::REQUEST_TYPE_API;
    /**
     * Class property holding instance of the DatabaseManager
     *
     * @var \Illuminate\Database\DatabaseManager
     */
    protected $db = null;
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->request = app ()->make ( 'request' );
        $this->auth = app ()->make ( 'auth' );
        $this->logger = app ()->make ( 'log' );
        $this->db = app ()->make ( 'db' );
        
        if ($this->auth->check ()) {
            $this->authUser = $this->auth->user ();
        }
    }
    /**
     * Get the property name through method name
     *
     * @param string $methodName            
     * @return string
     *
     */
    private function getExpectedPropertyName($methodName) {
        return lcfirst ( substr ( $methodName, 3 ) );
    }
    /**
     * Magic Method helps to define and get the class property with actual methods
     *
     * @param string $method            
     * @param array $parameters            
     * @return mixed
     *
     * @throws BadMethodCallException
     */
    public function __call($method, $parameters) {
        $classProperty = $this->getExpectedPropertyName ( $method );        
        if (! property_exists ( $this, $classProperty )) {
            throw new BadMethodCallException ( "Method [$method] does not exist." );
        }        
        switch (substr ( $method, 0, 3 )) {
            case 'get' :
                return $this->{$classProperty};
            case 'set' :
                $propertyValue = array_shift ( $parameters );
                $this->{$classProperty} = $propertyValue;
                break;
            default :
                throw new BadMethodCallException ( "Method [$method] does not exist." );
        }        
        return $this;
    }
    /**
     * get variouse configuration by model
     *
     * @param string $model            
     * @return mixed (object | null)
     */
    public function getFileConfigurationByModel($model) {
        $config = config ( "settings.image-settings.$model" ) ?: config ( "media.$model" );        
        if (! $config) {
            $config = config ( "settings.image-settings.default" );
        }        
        return ($config) ? ( object ) $config : null;
    }
}