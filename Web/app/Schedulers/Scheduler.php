<?php
/**
 * Scheduler
 *
 * This will hold the common scheduler methods those can be extended by different schedulers
 * @name       BaseScheduler
 * @version    1.0
 * @author     Contus<developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Schedulers;

use \Illuminate\Console\Scheduling\Event;

abstract class Scheduler {
    /**
     * The class property to hold the logger object
     *
     * @var object
     */
    protected $logger = null;    
    /**
     * Class contructor.
     *
     * @return void
     */
    public function __construct() {
        $this->logger  = app()->make('log');
    }
    /**
     * Abstruct Scheduler call method every child should be overwritten.
     * 
     * @return \Closure
     */
    public abstract function call();
    /**
     * Abstruct Scheduler frequency method every child should be overwritten.
     * this method used define the Scheduler's frequency
     * 
     * @param \Illuminate\Console\Scheduling\Event $event
     * @see https://laravel.com/docs/5.1/scheduling#schedule-frequency-options
     * @return void
     */
    public abstract function frequency(Event $event);    
}