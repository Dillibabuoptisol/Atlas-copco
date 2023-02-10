<?php
/**
 * Queue Manager
 *
 * @name       QueueManager
 * @package    Router
 * @version    1.0
 * @author     Contus<developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */

namespace Contus\Router;

use Illuminate\Queue\QueueManager as IlluminateQueueManager;

class QueueManager extends IlluminateQueueManager{
    /**
     * Class initalizer
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function __construct($app){
        $app['config']->set('queue',[
            "default" => env('QUEUE_DRIVER','event-beanstalkd'),
            "connections" => [
                'event-beanstalkd' => [
                    'driver' => 'beanstalkd',
                    'host'   => env('EVENT_BEANSTALKD_HOST','localhost'),
                    'queue'  => env('EVENT_BEANSTALKD_TUBE','event'),
                    'ttr'    => 60
                ],
                'service-beanstalkd' => [
                    'driver' => 'beanstalkd',
                    'host'   => env('SERVICE_BEANSTALKD_HOST','localhost'),
                    'queue'  => env('SERVICE_BEANSTALKD_TUBE','order-subscribed'),
                    'ttr'    => 60
                ]
            ],
            'failed' => [
                'database' => 'mysql', 'table' => 'failed_jobs',
            ]
        ]);

        parent::__construct($app);
    }
    /**
     * Get the name of the default queue connection.
     * since all the service communicate through event service
     * we prefer it as event as default
     *
     * @return string
     */
    public function getDefaultDriver(){
        return env('QUEUE_DRIVER','event-beanstalkd');
    }    
}
