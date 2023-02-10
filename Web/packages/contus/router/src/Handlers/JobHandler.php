<?php
/**
 * JobHandler
 *
 * Every job is listened and published to the subscribers
 *
 * @name      JobHandler
 * @version   1.0
 * @author    Contus Team <developers@contus.in>
 * @copyright Copyright (C) 2018 Contus. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 **/
namespace Contus\Router\Handlers;

use Exception;
use Event\Models\Event;

class JobHandler extends Handler{
    /**
     * Class property to hold the instance of Event
     *
     * @var \Event\Models\Event
     */
    protected $event = null;
    /**
     * Class initalizer
     *
     * @return void
     */
    public function __construct(){
        $this->event = new Event;
    }       
    /**
     * Handle the event dispatched by other service.
     * data also formatted here
     *
     * @param  array $data
     * @return void
     *
     */
    public function handle(array $data){
        if($this->validateJobData($data)){
            try {
                $this->event->publish($data['event'],$data);
                $this->eventLog->complete($data['identifier']);
            } catch (Exception $e) {
                $message = $exception->getMessage();

                $this->eventLog->logErrorMessage($data['identifier'],$message);
                app('log')->error($message);
            }

            app('contus.router.logger')->logToModel();
        }
    }
}