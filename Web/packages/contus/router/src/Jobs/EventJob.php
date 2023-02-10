<?php
/**
 * EventJob
 *
 * @name       EventJob
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Router\Jobs;

use Contus\Router\Handlers\JobHandler;

class EventJob extends Job{
    /**
     * Class property to to hold the queue data.
     *
     * @var array
     */
    protected $data = [];
    /**
     * class initializer.
     *
     * @param  array $data
     * @return void
     */
    public function __construct(array $data = []){
        $this->data = $data;
    }
    /**
     * Execute the job.
     * this method is magic,since it will common across the service
     * same object is shared,hence this job is always queued to event beanstalkd
     * here will invoke the event service event listner with job data
     *
     * @return void
     */
    public function handle(){
        (new JobHandler)->handle($this->data);
    }
}
