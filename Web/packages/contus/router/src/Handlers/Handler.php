<?php
/**
 * Handler Abstract
 *
 * @name      Handler
 * @version   1.0
 * @author    Contus Team <developers@contus.in>
 * @copyright Copyright (C) 2018 Contus. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 **/
namespace Contus\Router\Handlers;

use Contus\Router\Models\EventLog;

abstract class Handler{
    /**
     * Class property to hold the instance of EventLog
     *
     * @var \Contus\Router\Models\EventLog
     */
    protected $eventLog = null;         
    /**
     * Validate job data
     * 1) check the event exists in data
     * 2) check the identifier exists in data
     * 3) check the event log model exists
     *
     * @param  array $data
     * @return boolean
     *
     */
    protected function validateJobData(array $data){
        $this->eventLog = new EventLog;

        return (
            array_key_exists('event',$data) 
            && array_key_exists('identifier',$data)
            && ($this->eventLog = $this->eventLog->getEventLogByIdentifier($data['identifier']))
        );
    }      
}