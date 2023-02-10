<?php
/**
 * To manage Validation handler configuration exception
 *
 * @name       ValidationHandler
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Base\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Validation\ValidatesRequests;

trait ValidationHandler {
    use ValidatesRequests;
    /**
     * class property to hold the rules for validation
     *
     * @var array
     */
    private $rules = [ ];
    /**
     * class property to hold the custome messages for validation
     *
     * @var array
     */
    private $messages = [ ];
    /**
     * class property to hold the custom attributes for validation
     *
     * @var array
     */
    private $customAttributes = [ ];
    /**
     * Get current repository rules
     *
     * @return array
     */
    public function getRules() {
        return $this->rules;
    }
    /**
     * Set Rules for the existing repository
     * allow to overwrite the default validation rule
     *
     * @param array $rules            
     * @return array BaseRepository
     */
    public function setRules(array $rules) {
        $this->rules = $rules;        
        return $this;
    }
    /**
     * Set Rule for the existing repository
     * allow to overwrite the default validation rule for a field
     *
     * @param string $field            
     * @param string $rule            
     * @return array BaseRepository
     */
    public function setRule($field, $rule) {
        $this->rules [$field] = $rule;        
        return $this;
    }
    /**
     * get Rule by field
     *
     * @param string $field            
     * @return mixed (string | null)
     */
    public function getRule($field) {
        return (isset ( $this->rules [$field] )) ? $this->rules [$field] : null;
    }
    /**
     * Set custom message
     *
     * @param string $field            
     * @param string $message            
     * @return mixed (string | null)
     */
    public function setMessage($field, $message) {
        $this->messages [$field] = $message;        
        return $this;
    }
    /**
     * Set custom attributes
     *
     * @param string $field            
     * @param string $name            
     * @return mixed (string | null)
     */
    public function setCustomAttributes($field, $name) {
        $this->customAttributes [$field] = $name;        
        return $this;
    }
    /**
     * Remove Rule for the existing repository
     * allow to remove rule by field
     *
     * @param string $field            
     * @return array BaseRepository
     */
    public function removeRule($field) {
        if (isset ( $this->rules [$field] )) {
            unset ( $this->rules [$field] );
        }        
        return $this;
    }    
    /**
     * Remove Rules for the existing repository
     * allow to remove rules by field
     *
     * @param string $fields            
     * @return array BaseRepository
     */
    public function removeRules($fields) {
        foreach ( $fields as $field ) {
            if (isset ( $this->rules [$field] )) {
                unset ( $this->rules [$field] );
            }
        }        
        return $this;
    }
    /**
     * Intiate the validation based on the defined rules
     * 
     * @return array BaseRepository
     *
     * @throws \Illuminate\Http\Exception\HttpResponseException
     */
    protected function _validate() {
        $this->validate ( $this->request, $this->rules, $this->messages, $this->customAttributes );    
        return $this;
    }
    /**
     * Create the response for when a request fails validation.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  array  $errors
     * @return \Illuminate\Http\Response
     */
    protected function buildFailedValidationResponse(Request $request,array $errors){
        return ($request->ajax() || $request->wantsJson() || $this->requestType == static::REQUEST_TYPE_API)
            ? new JsonResponse(['error' => true, 'statusCode' => 422, 'messages' => $errors], 422) 
            : redirect()->to($this->getRedirectUrl())->withInput($request->input())->withErrors($errors, $this->errorBag());
    }
}