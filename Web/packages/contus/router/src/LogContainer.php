<?php
/**
 * Hold the logger for every route
 *
 * @name       LogContainer
 * @package    Router
 * @version    1.0
 * @author     Contus<developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Router;

use Illuminate\Log\Writer;
use Psr\Http\Message\ResponseInterface;
use Contus\Router\Exceptions\InvalidLoggerModelException;

class LogContainer{
    /**
     * Class static property for holding various logger models available
     * 
     * @var array
     */
    private $loggerModels = [ 
      \Contus\Router\Models\RouterLog::class,
      \Contus\Router\Models\EventLog::class
    ];    
    /**
     * Class property to hold the logs
     *
     * @var array
     */
    private $logs = [];
    /**
     * Class property to hold current logger model
     *
     * @var array
     */
    private $loggerModel = \Contus\Router\Models\RouterLog::class;    
    /**
     * Class property to logger instance
     *
     * @var \Monolog\Logger
     */
    protected $logger;        
    /**
     * Class intializer.
     *
     * @param \Illuminate\Log\Writer $logger
     * @return void
     */
    public function __construct(Writer $logger) {
        $this->logger = $logger;
        
        $this->logs[$this->loggerModel] = [];
    }    
    /**
     * Add router log
     *
     * @param array $elements
     * @return string
     */
    public function add($elements){
        $loggerId = uniqid();

        $this->logs[$this->loggerModel][$loggerId] = $elements;

        return $loggerId;
    }
    /**
     * update router logged with response
     *
     * @param string $loggerId
     * @param array $elements
     * @return void
     */
    public function update($loggerId,array $elements){
        if(isset($this->logs[$this->loggerModel][$loggerId])){
            $this->logs[$this->loggerModel][$loggerId] = array_merge($this->logs[$this->loggerModel][$loggerId],$elements);
        }
    }
    /**
     * Delete router logged by logger id
     *
     * @param string $loggerId
     * @return void
     */
    public function delete($loggerId){
        if(isset($this->logs[$loggerId])){
           unset($this->logs[$loggerId]);
        }
    }    
    /**
     * get all logs
     *
     * @return array
     */
    public function getLogs(){
        return $this->logs[$this->loggerModel];
    }
    /**
     * set logger model
     *
     * @param string $loggerModel
     * @return void
     *
     * @throws \Contus\Router\Exceptions\InvalidLoggerModelException
     */
    public function setLoggerModel($loggerModel){
        if(in_array($loggerModel, $this->loggerModels)){
            $this->loggerModel = $loggerModel;
            return;
        }

        throw new InvalidLoggerModelException("Invalid Logger Model is set for LogContainer");
    } 
    /**
     * Log to logger model
     *
     * @return void
     */
    public function logToModel(){
        if($this->loggerModel){
            try {
                $loggerModel = new $this->loggerModel;
                
                $loggerModel->log($this);
            } catch (Exception $e) {
                $this->logger->error($e);
            }
        }
    }                    
}
