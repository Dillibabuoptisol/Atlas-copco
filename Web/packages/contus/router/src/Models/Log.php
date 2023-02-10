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

use Contus\Router\LogContainer;
use Illuminate\Database\Eloquent\Model;

abstract class Log extends Model{
    /**
     * class property to hold the connection name for the model.
     *
     * @var string
     */
    protected $connection = 'loggersql'; 
    /**
     * class property to hold the logger instance.
     *
     * @var \Monolog\Logger
     */
    protected $logger;        
    /**
     * Create a new RouterLog model instance.
     *
     * @return void
     */
    public function __construct(){
        parent::__construct();

        $this->service = app('config')->get('service.name',"NA");
        $this->logger = app('log');
    }
    /**
     * Dump the logcontainer log to db
     *
     * @param Contus\Router\LogContainer $logContainer
     * @return void
     */
    public abstract function log(LogContainer $logContainer);
    /**
     * get failed log directory or file path
     *
     * @param string $path 
     * @return string
     */
    protected function getFailedLogsFilePath($path = ''){ 
       return storage_path().DIRECTORY_SEPARATOR.'failedlogs'.DIRECTORY_SEPARATOR.$path;
    }     
    /**
     * Check and make failed logs directory
     *
     * @return boolean
     */
    protected function checkAndMakeFailedLogsDirectory(){
        $fileSystem = app('files');
        $failedLogsDirectoryPath = $this->getFailedLogsFilePath();

        if(!$fileSystem->isDirectory($failedLogsDirectoryPath)){
            $fileSystem->makeDirectory($failedLogsDirectoryPath);
        }
    }                   
    /**
     * write the router log data to the file
     *
     * @return void
     */
    protected function writeLoggerToFileSystem(){ 
        try {
            $this->checkAndMakeFailedLogsDirectory();

            file_put_contents(
                $this->getFailedLogsFilePath(
                    time()."-".substr(get_class($this),(strrpos(get_class($this),'\\') + 1))."-".uniqid().".json"
                )
                ,$this->toJson()
            );
        } catch (Exception $e) {
            $this->logger->error($e);
        }
    }       
}
