<?php
/**
 * Json Response Parser
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
use Contus\Router\Exceptions\ResponseParserException;

class JsonParser extends Parser{ 
    /**
     * Parse the Response 
     *
     * @param \Psr\Http\Message\ResponseInterface
     * @return mixed
     */
    public function parse(ResponseInterface $response){
        $parsedResponse = [];
        $contentType = $this->getContentType($response);

        if($contentType == static::APPLICATION_JSON) {
            $parsedResponse = json_decode($response->getBody()->getContents(),1);

            static::checkDecode();
        }

        return $parsedResponse;
    }
    /**
     * Encode the array to Json 
     *
     * @param array $data
     * @return string
     */
    public static function encode(array $data){
        $encodedData = json_encode($data);

        static::checkDecode();

        return $encodedData;
    }    
    /**
     * Check the decode is completed successfully or not
     *
     * @param \Psr\Http\Message\ResponseInterface
     * @return void
     * @throws \Contus\Router\Exceptions\ResponseParserException
     */
    private static function checkDecode(){
        $errorMessage = null;

        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                $errorMessage = null;
            break;            
            case JSON_ERROR_DEPTH:
                $errorMessage = 'Maximum stack depth exceeded';
            break;
            case JSON_ERROR_STATE_MISMATCH:
                $errorMessage = 'Underflow or the modes mismatch';
            break;
            case JSON_ERROR_CTRL_CHAR:
                $errorMessage = 'Unexpected control character found';
            break;
            case JSON_ERROR_SYNTAX:
                $errorMessage = 'Syntax error, malformed JSON';
            break;
            case JSON_ERROR_UTF8:
                $errorMessage = 'Malformed UTF-8 characters, possibly incorrectly encoded';
            break;
            default:
                $errorMessage = 'Unknown error';
            break;
        }

        if($errorMessage){
            throw new ResponseParserException($errorMessage);
        }
    }                 
}