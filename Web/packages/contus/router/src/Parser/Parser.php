<?php
/**
 * Parser Abstract class 
 *
 * @name       JsonParser
 * @package    Router
 * @version    1.0
 * @author     Contus<developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Router\Parser;

use Psr\Http\Message\ResponseInterface;

abstract class Parser{
    /**
     * Class const to hold the response content type
     *
     * @var const
     */
    const APPLICATION_JSON = 'application/json';
    /**
     * Parse the response
     *
     * @param \Psr\Http\Message\ResponseInterface
     * @return mixed
     */
    public abstract function parse(ResponseInterface $response); 
    /**
     * Get content type of the Response 
     *
     * @param \Psr\Http\Message\ResponseInterface
     * @return string | null
     */
    protected function getContentType(ResponseInterface $response){
        $contentType = $response->hasHeader('Content-Type') 
                    ? $response->getHeader('Content-Type') : false;

        /**
         * getHeader returns the array
         * so we will take out the first element and parse according to it
         */            
        if(is_array($contentType)){
            $contentType = array_shift($contentType);
        }


        return $contentType;
    }    
}