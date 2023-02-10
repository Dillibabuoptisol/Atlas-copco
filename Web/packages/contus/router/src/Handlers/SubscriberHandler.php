<?php
/**
 * SubscriberHandler
 *
 * Every subscriber job is listened and published to the subscriber listeners
 *
 * @name      SubscriberHandler
 * @version   1.0
 * @author    Contus Team <developers@contus.in>
 * @copyright Copyright (C) 2018 Contus. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 **/
namespace Contus\Router\Handlers;

use Exception;

class SubscriberHandler extends Handler{
    /**
     * Handle the event dispatched by other service.
     * data also formatted here
     *
     * @param  array $data
     * @return void
     */
    public function handle(array $data){
        if(
            $this->validateJobData($data) 
            && ($listenerClass = app('config')->get("service.events.listeners.".$data['event']))
        ){
            try {
                $listenerClass = app()->build($listenerClass);
                $listenerClass->handle($data);

                $this->eventLog->complete($data['identifier']);      
            } catch (Exception $exception) {
                $this->eventLog->logErrorMessage($data['identifier'],$exception->getMessage());
                app('log')->error($exception);
            }
        }
    }
}