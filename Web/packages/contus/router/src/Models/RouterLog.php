<?php
/**
 * Router Log Model
 *
 * This model will going to hold the table related to router log
 *
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 **/
namespace Contus\Router\Models;

use Exception;
use Contus\Router\LogContainer;
use Contus\Router\Parser\JsonParser;

class RouterLog extends Log{           
    /**
     * Class const to hold the available request method
     *
     * @var const
     */
    const REQUEST_METHOD_GET = 'GET';
    const REQUEST_METHOD_POST = 'POST';
    const REQUEST_METHOD_PUT = 'PUT';
    const REQUEST_METHOD_PATCH = 'PATCH';
    const REQUEST_METHOD_OPTIONS = 'OPTIONS';
    const REQUEST_METHOD_DELETE = 'DELETE';
    const REQUEST_METHOD_TRACE = 'TRACE';
    /**
     * Class static property for holding various request method available
     * 
     * @var array
     */
    public static $requestMethods = [ 
      self::REQUEST_METHOD_GET,
      self::REQUEST_METHOD_POST,
      self::REQUEST_METHOD_PUT,
      self::REQUEST_METHOD_PATCH,
      self::REQUEST_METHOD_OPTIONS,
      self::REQUEST_METHOD_DELETE,
      self::REQUEST_METHOD_TRACE 
    ];       
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url',
        'request_data',
        'response_data',
        'error_message',
        'is_asynchronous',
        'status_code'
    ];    
    /**
     * Dump the logcontainer log to db
     *
     * @param Contus\Router\LogContainer $logContainer
     * @return void
     */
    public function log(LogContainer $logContainer){
        foreach ($logContainer->getLogs() as $loggerId => $log) {
            try {
                $routerLog = (new static)->fill($log);

                if($routerLog->status_code == 200){
                    $routerLog->is_completed = 1;
                }

                if(isset($log['method'])){
                    $routerLog->defineMethod($log['method']);
                }

               $routerLog->convertToJson()->save(); 
            } catch (Exception $e) {
                $routerLog->writeLoggerToFileSystem(); 
                $this->logger->error($e->getMessage());
            }
        }
    }
    /**
     * Define method name
     * aync method will be suffixed by Asyc
     * so it is removed and method type is set
     *
     * @param string $method
     * @return void
     */
    public function defineMethod($method){       
        if(strpos($method, 'Async') !== false){
            $method = substr($method, 0,(strlen($method) - 5));
        }

        $this->method = strtoupper($method);
    }    
    /**
     * Convert every element with array value to JSON 
     *
     * @return RouterLog
     */
    public function convertToJson(){       
        $this->request_data = JsonParser::encode($this->request_data);
        $this->response_data = JsonParser::encode($this->response_data);

        return $this;
    }                      
}
