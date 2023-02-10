<?php
/**
 * UserApiController
 *
 * To manage user related activities
 *
 * @name       UserApiController
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Http\Controllers\Api;

use Admin\Repositories\UserRepository;
use Contus\Base\Controllers\Api\ApiController;

class UserApiController extends ApiController {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository) {
        parent::__construct ();
        $this->repository = $userRepository;
    }
    
    /**
     * Function to authenticate user
     * it will takes the email and password as input and check and returns the response
     *
     * @return json object
     */
    public function postLogin() {
        
        $isLoggedin = false;
        $data = $this->repository->checkLogin ();
        if ($data [STATUS]) {
            $isLoggedin = true;
        }
        return ($isLoggedin) ? $this->getSuccessJsonResponse ( [ 
                RESPONSE => $data 
        ], $data [MESSAGE] ) : $this->getErrorJsonResponse ( [ ], $data [MESSAGE], $data [CODE] );
    }
    
    public function logininfo() {
        $isLoggedin = false;
        $data = $this->repository->verifylogin ();
        if ($data [STATUS]) {
            $isLoggedin = true;
        }
        return ($isLoggedin) ? $this->getSuccessJsonResponse ( [ 
                RESPONSE => $data 
        ], $data [MESSAGE] ) : $this->getErrorJsonResponse ( [ ], $data [MESSAGE], $data [CODE] );
    }

         /**
     * This method used to send link for forgot password
     *      
     * @return array
     */
    public function sendForgotPasswordLink(){
        return $this->repository->sendForgotPasswordLink();
    }
    
    /**
     * This method used to reset the password
     *      
     * @return array
     */
    public function resetPassword(){
        return $this->repository->resetPassword();
    }

}
