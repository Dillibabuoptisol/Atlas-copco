<?php

namespace Admin\Console;

use Closure;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Admin\Schedulers\Scheduler;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
    
    ];

    /**
     * Class property to hold the scheduler configuration.
     *
     * @var array
     */
    protected $schedulerConfig = [];    
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule){
        $this->schedulerConfig = config('scheduler') ?: [];
        
        if(is_array($this->schedulerConfig)){
            $this->defineScheduler($schedule);
        }
    }
    /**
     * Define the configured Scheduler.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function defineScheduler(Schedule $schedule){
        foreach ($this->schedulerConfig as $scheduler){
            if($schedulerInstance = $this->createSchedulerInstance($scheduler)){
                $callable = $schedulerInstance->call();
                
                if($callable instanceof Closure){
                    $schedulerInstance->frequency($schedule->call($callable));
                }
            }
        }
    }    
    /**
     * Create Scheduler instance.
     *
     * @param  string $scheduler
     * @return \Digicomm\Schedulers\Scheduler | null
     * @throws \Exception
     */
    protected function createSchedulerInstance($scheduler){
        $schedulerInstance = null;
        
        try {
            $schedulerInstance = app()->build($scheduler);
        } catch (Exception $e) {
           app()->make('log')->error($e->getMessage());
        }

        if(!is_null($schedulerInstance) && !$schedulerInstance instanceof Scheduler){
            app()->make('log')->error("[$scheduler] should be child class of the [Admin\Schedulers\Scheduler]");
            throw new Exception("[$scheduler] should be child class of the [Admin\Schedulers\Scheduler]");
        }
        
        return $schedulerInstance;
    } 
    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
