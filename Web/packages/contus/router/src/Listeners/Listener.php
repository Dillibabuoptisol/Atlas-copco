<?php
/**
 * Abstract Listener
 *
 * @name      Listener
 * @version   1.0
 * @author    Contus Team <developers@contus.in>
 * @copyright Copyright (C) 2018 Contus. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 **/
namespace Contus\Router\Listeners;

use Contus\Router\Exceptions\InvalidEventDataException;

abstract class Listener{
    /**
     * Handle the event dispatched by other service.
     *
     * @param  array $data
     * @return void
     */
    public abstract function handle(array $data);
    /**
     * throw Invalid Event Data Exception
     *
     * @param  string $message
     * @return void
     * @throws \Contus\Router\Exceptions\InvalidEventDataException
     */
    protected function throwInvalidEventDataException($message){
      throw new InvalidEventDataException($message);
    }
    /**
     * Validate event data has expected keys
     *
     * @param  array $arrayKeysExcpected
     * @param  array $data
     * @return boolean
     */
    public function validateData(array $arrayKeysExcpected,array $data){
        $hasKeys = true;

        foreach ($arrayKeysExcpected as $key) {
            if(!array_key_exists($key, $data)){
                $hasKeys = false;
            }
        }

        if($hasKeys === false){
            $this->throwInvalidEventDataException("Error Processing Request");
        }
    }
    /**
     * build query string from array
     *
     * @param  array $querys
     * @return string
     */
    public function buildQueryStringFromArray(array $querys){
        $queryString = false;

        foreach ($querys as $key => $value) {
            $queryString = $queryString ? "$queryString&" : "?";
            
            if(is_array($value)){
                $i = 0;
                foreach($value as $aKey => $aValue) {
                    if($i > 0){
                        $queryString .= '&';
                    }      

                    $queryString .= $key.'[]='.$aValue;

                    $i++;        
                }   
            }        
            
        }

        return $queryString;
    }    
}