<?php
/**
 * To manage response handler configuration exception
 *
 * @name       ResponseHandler
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Base\Traits;

use Illuminate\Validation\ValidationException;

trait ResponseHandler {
    /**
     * get success json response
     *
     * @param array $data            
     * @param string $message            
     * @param int $statusCode            
     * @return array response
     */
    protected function getSuccessJsonResponse(array $data = [], $message = null, $statusCode = 200) {
        return response ()->json ( array_merge ( [ 
                ERROR => false,
                STATUSCODE => $statusCode,
                MESSAGE => $message 
        ], $data ), $statusCode );
    }
    /**
     * get error json response
     *
     * @param array $data            
     * @param string $message            
     * @param int $statusCode            
     * @return array response
     */
    protected function getErrorJsonResponse(array $data = [], $message = null, $statusCode = 500) {
        return response ()->json ( array_merge ( [ 
                ERROR => true,
                STATUSCODE => $statusCode,
                MESSAGE => $message 
        ], $data ), $statusCode );
    }
    /**
     * Create a response object from the given validation exception.
     *
     * @param \Illuminate\Validation\ValidationException $e            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e) {
        return ($e->response) ? ($e->response) : response ()->json ( $e->validator->errors ()->getMessages (), 422 );
    }
}