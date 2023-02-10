<?php
/**
 * DispatchToQueueCommand
 *
 * @name       DispatchToQueueCommand
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Router\Console;

use Illuminate\Console\Command;

class DispatchToQueueCommand extends Command{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'router:dispatch
                            {connection? : The name of connection}
                            {--event= : The queue to listen on}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch a event to queue stack';
    /**
     * Execute the console command.
     * dispatch the event job with data and log the same 
     *
     * @return void
     */
    public function fire() {
        $queueDriver = $this->argument('connection');
        $event = $this->option('event') ?: 'CUSTOMER_CREATED';
        $dispatcher = app('contus.router.dispatcher'); 
        
        if($queueDriver){
            $dispatcher->setQueueDriver($queueDriver);
        }
            
        $dispatcher->dispatch(['event' => $event]);

        app('contus.router.logger')->logToModel();

        $this->info("{$event} Job is Dispatched.");
    }
}
