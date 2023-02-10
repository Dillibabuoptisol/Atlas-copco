<?php
/**
 * SubscriberJob
 *
 * @name       SubscriberJob
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Router\Jobs;

use Contus\Router\Handlers\SubscriberHandler;

class SubscriberJob extends Job{
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
     * same object is shared
     *
     * @return void
     */
    public function handle(){
        (new SubscriberHandler)->handle($this->data);
    }
}
