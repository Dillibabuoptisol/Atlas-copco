<?php
/**
 * Dispatcher
 *
 * @name       Dispatcher
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Router;

use Exception;
use Contus\Router\Models\EventLog;
use Contus\Router\Exceptions\InvalidClassException;

class Dispatcher{
    /**
     * Class property to hold the instance of LogContainer
     *
     * @var \Contus\Router\LogContainer
     */
    protected $logContainer = null;
    /**
     * Class property to hold the instance of LogContainer
     *
     * @var string
     */
    protected $jobClass = \Contus\Router\Jobs\EventJob::class;         
    /**
     * Class initalizer
     *
     * @param  \Contus\Router\LogContainer $logContainer
     * @return void
     */
    public function __construct(LogContainer $logContainer){
        $this->logContainer = $logContainer;

        $this->logContainer->setLoggerModel(EventLog::class);

        $this->setQueueDriver("event-beanstalkd");
    }
    /**
     * dispatch the data to the event beanstalk queue
     * catch various exceptions and logs error exceptions
     * 
     * @param array $data
     * @return void
     */
    public function dispatch(array $data){
        $loggerId = $this->logContainer->add(['data' => $data]);
        
        try {
            $data['identifier'] = uniqid();

            $jobIdentifier = dispatch(new $this->jobClass($data));
            
            $this->logContainer->update($loggerId,[
                "job_id"       => $jobIdentifier,
                "queue_driver" => env("QUEUE_DRIVER","event-beanstalkd"),
                "identifier" => $data['identifier'],
                "is_job_pushed" => 1
            ]);
        } catch (Exception $e) {
            $this->logContainer->update($loggerId,["error_message" => $e->getMessage()]);
            app('log')->error($e);
        }
    }
    /**
     * Set the queue driver for current dispatched job.
     * overwritten the existing beanstalkd configuration
     *
     * Note 
     * If PHP is running as an Apache module and an existing
     * Apache environment variable exists, overwrite it
     *
     * @param string $queueDriver
     * @return Dispatcher
     */
    public function setQueueDriver($queueDriver){
        if(function_exists('apache_getenv') && apache_getenv('QUEUE_DRIVER')) {
            apache_setenv('QUEUE_DRIVER',$queueDriver);
        }

        if (function_exists('putenv')) {
            putenv("QUEUE_DRIVER=$queueDriver");
        }

        return $this;
    }
    /**
     * set job class used for dispatching the data
     * based on the queue driver preferred
     * event queue uses EventJob likewise subscriber driver uses
     * SubscribersJob
     *
     * @param string $jobClass
     * @return Dispatcher
     * @throws \Contus\Router\Exceptions\InvalidClassException
     */
    public function setJobClass($jobClass){
        if(!class_exists($jobClass)){
            throw new InvalidClassException("Job Class does not exists");
        }

        $this->jobClass = $jobClass;

        return $this;
    }            
}
