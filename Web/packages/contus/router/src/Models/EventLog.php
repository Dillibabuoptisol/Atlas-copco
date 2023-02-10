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

class EventLog extends Log{    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'job_id',
        'queue_driver',
        'identifier',
        'is_job_pushed',
        'data',
        'error_message'
    ];   
    /**
     * Dump the logcontainer log to db
     *
     * @param Contus\Router\LogContainer $logContainer
     * @return void
     */
    public function log(LogContainer $logContainer){
        foreach ($logContainer->getLogs() as $log) {
            try {
                (new static)->fill($log)->convertToJson()->save(); 
            } catch (Exception $e) {
                $this->writeLoggerToFileSystem(); 
                $this->logger->error($e->getMessage());
            }
        }
    }   
    /**
     * Convert every element with array value to JSON 
     *
     * @return EventLog
     */
    public function convertToJson(){       
        $this->data = JsonParser::encode($this->data);

        return $this;
    }
    /**
     * Log error message occured to log using identifier 
     * 
     * @param string $identifier
     * @param string $message
     * @return void
     */
    public function logErrorMessage($identifier,$message){       
        if($this->exists){
            $this->error_message = $message;
            $this->save();
        }
    }
    /**
     * Complete the log using identifier  
     * 
     * @param string $identifier
     * @return void
     */
    public function complete($identifier){       
        if($this->exists){
            $this->is_completed = 1;
            $this->save();
        }
    } 
    /**
     * Get event log by identifier
     * 
     * @param string $identifier
     * @return EventLog
     */
    public function getEventLogByIdentifier($identifier){       
        return $this->where('identifier',$identifier)->first();
    }                                  
}
