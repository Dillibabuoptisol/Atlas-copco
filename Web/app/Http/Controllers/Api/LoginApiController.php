<?php
/**
 * RoleApiController
 *
 * To manage admin roles api related activities
 *
 * @name       RoleApiController
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Http\Controllers\Api;

use Admin\Repositories\LoginApiRepository;
use Contus\Base\Controllers\Api\ApiController;


class LoginApiController extends ApiController {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LoginApiRepository $loginApiRepository) {
        parent::__construct ();
        $this->repository = $loginApiRepository;
    }
     /**
     * Function to get JWT token
     * it will takes the email and password as input and give the JWT token
     *
     * @return json object
     */
    public function authLogin() {
        return $this->repository->login ();
    }

     /**
     * Function to Update user password
     * it will takes the email and password as input and update the password and  returns the response
     *
     * @return json object
     */
    public function updatePassword() {
        return $this->repository->updatePassword();
    }

     /**
     * Function to Update user profile
     * it will takes the name and mobile number as input and update the name,mobile number and returns the response
     *
     * @return json object
     */
    public function getProfile() {
        return $this->repository->getProfile();
    }
        /**
     * Function to register user
     * it will register the name,email,password,collector_id and mobile number  and returns the response
     *
     * @return json object
     */
    public function register() {
        return $this->repository->register();
    }
         /**
     * Function to Update user profile
     * it will takes the name and mobile number as input and update the name,mobile number and returns the response
     *
     * @return json object
     */
    public function updateProfile() {
        return $this->repository->updatProfile();
    }

     /**
     * Function to Change user Password
     * it will takes the Email  as input and update the password and returns the response
     *
     * @return json object
     */
    public function changePassword() {
        return $this->repository->changePassword();
    }

    /**
     * Function to to send Forgot Password
     * it will takes the email and password as input and update the password and  returns the response
     *
     * @return json object
     */
    public function forgotPassword() {
        return $this->repository->sendForgotPassword();
    }
}
