<?php
/**
 * ApiController
 *
 * To manage api related activities
 *
 * @name       ApiController
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Base\Controllers\Api;

use Illuminate\Http\Request;
use Contus\Base\Traits\CrudResponseHandler;
use Contus\Base\Controllers\Controller;

abstract class ApiController extends Controller {
    /**
     * Handle resource based request(index,create,store,show,edit,update,destroy)
     * map the request to appropriate repository methods and return the response
     */
    use CrudResponseHandler;    
    /**
     * Class constants for holding request type handled by child controllers
     *
     * @var const
     */
    const REQUEST_TYPE = 'API';
    /**
     * Class constants for holding  resource method available
     *
     * @var const
     */
    const RESOURCE_METHOD_INDEX = 'index';
    const RESOURCE_METHOD_CREATE = 'create';
    const RESOURCE_METHOD_STORE = 'store';
    const RESOURCE_METHOD_SHOW = 'show';
    const RESOURCE_METHOD_EDIT = 'edit';
    const RESOURCE_METHOD_UPDATE = 'update';
    const RESOURCE_METHOD_DESTROY = 'destroy';
    const RESOURCE_METHOD_ACTION = 'action';
    /**
     * The auth registered on Base Controller.
     *
     * @var object
     */
    protected static $resourceMethods = [
        self::RESOURCE_METHOD_INDEX,
        self::RESOURCE_METHOD_CREATE,
        self::RESOURCE_METHOD_STORE,
        self::RESOURCE_METHOD_SHOW,
        self::RESOURCE_METHOD_EDIT,
        self::RESOURCE_METHOD_UPDATE,
        self::RESOURCE_METHOD_DESTROY,
        self::RESOURCE_METHOD_ACTION
    ];
    /**
     * The auth registered on Base Controller.
     *
     * @var object
     */
    protected $auth;
    /**
     * The class property to hold the logger object
     *
     * @var object
     */
    protected $logger;
    /**
     * The class property to hold the request object
     *
     * @var object
     */
    protected $request;
    /**
     * Class property to hold the upload repository object
     *
     * @var Admin\Repositories\Repository
     */
    protected $repository = null;
    /**
     * class intializer
     *
     * @return void
     */
    public function __construct() {
        $this->auth = app ()->make ('auth');
        $this->logger = app ()->make ('log');
        $this->request = app ()->make ('request');
    }
    /**
    * Check method is a resource method
    *
    * @param string $method
    * @return boolean
    */
    protected function isResourceMethod($method) {
      return in_array($method, static::$resourceMethods);
    } 
    /**
     * Check request is made from mobile app
     * check request header has x-moverbee-mobile
     * 
     * @return boolean
     */
    protected function isMobileRequest() {
      return app('request')->headers->has ('x-moverbee-mobile');
    }
}