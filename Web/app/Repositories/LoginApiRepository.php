<?php
/**
 * LoginApiController
 *
 * To manage user controller
 *
 * @name       LoginApiController
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Repositories;
use Contus\Base\Repositories\Repository;
use Illuminate\Auth\Access\Response;
use Admin\Models\Collector;
use JWTAuth;
use JWTAuthException;
use Admin\Models\Setting;
use Admin\Models\EmailTemplate;
class LoginApiRepository extends Repository {
    /**
     * Create a new model instance.
     *
     * @return json
     */
    public function __construct(Collector $collector,Setting $setting,EmailTemplate $emailTemplate) {
        parent::__construct();
        $this->collector = $collector;
        $this->setting = $setting;
    }

    /**
     * @SWG\Post(
     *      path="/api/v1/auth/login",
     *      tags={"Login JWT Token"},
     *      summary="To get the JWT token",
     *      operationId="JWTToken",
     *      @SWG\Parameter(
     *              name="x-request-type",
     *              in="header",
     *              required=true,
     *              type="string",
     *              default="mobile",
     *      ),
     *      @SWG\Parameter(
     *          name="email",
     *              in="formData",
     *              required=false,
     *              type="string",
     *              default="sujankumar.s@contus.in",
     *      ),
     *      @SWG\Parameter(
     *              name="mobile_number",
     *              in="formData",
     *              required=false,
     *              type="string",
     *              default="9874561230",
     *      ),
     *      @SWG\Parameter(
     *              name="password",
     *              in="formData",
     *              required=true,
     *              type="string",
     *              default="123456",
     *      ),
     *    @SWG\Response(response=200, description="Sucessfully token created"),
     *    @SWG\Response(response=401, description="Token is invalid / Token is expired")
     * )
     */


    
    /**
     * Validate authorized  users.
     *
     * @return json
     */
    public function login() {
        $userRules = ['password' => 'required', ];
        $this->setRules($userRules);
        $this->_validate();
        $username = $this->UsernameChecker();
        $collectorObject = $this->collector->where('mobile_number', '=', $this->request->mobile_number)->orWhere('email',$this->request->email)->first();
        if ($username) {
        $credentials = $this->request->only($username, 'password');
            return $this->verifyuser($credentials,$username);
        }elseif($collectorObject){
            if ($collectorObject->is_active == 0) {
                return $this->getSuccessJsonResponse(['is_active' => 0], 'Your account is deactivated', 422);
            }
        }else{
            return $this->getErrorJsonResponse(['is_active' => 2], 'User not exists', 422);
        }

    }

    /**
     * Return JWT token for authorized users.
     *
     * @return json
     */
    public function verifyuser($credentials,$username){
                $token = null;
                try {
                    if (!$token = JWTAuth::attempt($credentials)) {
                        return $this->getErrorJsonResponse(['is_active' => 3], 'Invalid email or password', 422);
                    }
                }
                catch(JWTAuthException $e) {
                    return $this->getErrorJsonResponse([], 'Failed to create token', 422);
                }
                return $this->returnLoginResponse($username,$token);
    }

     /**
     * Identify user and return returnLoginResponse
     *
     * @return json
     */
    public function returnLoginResponse($username,$token){
        if ($username == 'mobile_number') {
            $collectorObject = $this->collector->where('mobile_number', '=', $this->request->mobile_number)->select('email','is_new_user','is_active')->first();
            return $this->getSuccessJsonResponse(['token' => $token,'email' => $collectorObject->email,'is_new_user'=> $collectorObject->is_new_user,'is_active' => $collectorObject->is_active], 'Sucessfully token created', 200);
        }else{
              $collectorObject = $this->collector->where('email', '=', $this->request->email)->select('email','is_new_user','is_active')->first();
            return $this->getSuccessJsonResponse(['token' => $token,'email' => $this->request->email,'is_new_user'=> $collectorObject->is_new_user,'is_active' => $collectorObject->is_active], 'Sucessfully token created', 200);
        }
    }

     /**
     * Identify user using email or mobile Number for login
     *
     * @return json
     */
    public function UsernameChecker() {
        $email =$this->request->email;
        $mobile_number =$this->request->mobile_number;
        if ($email || $mobile_number ) {
            if ($this->checkUserActivation($email)) {
                return 'email';
            } elseif($this->checkUserActivation('',$mobile_number)) {
                return 'mobile_number';
            } else {
                return false;
            }
        }
    }

    /**
     * @SWG\Post(
     *      path="/api/v1/updatepassword",
     *      tags={"Update Password"},
     *      operationId="updatePassword",
     *      summary="Update Password API",
     *      @SWG\Parameter(
     *              name="x-request-type",
     *              in="header",
     *              required=true,
     *              type="string",
     *              default="mobile",
     *      ),
     *      @SWG\Parameter(
     *              name="token",
     *              in="header",
     *              required=true,
     *              type="string",
     *              default="",
     *      ),
     *      @SWG\Parameter(
     *              name="email",
     *              in="formData",
     *              required=true,
     *              type="string",
     *              default="sujankumar.s@contus.in",
     *      ),
     *      @SWG\Parameter(
     *              name="password",
     *              in="formData",
     *              required=true,
     *              type="string",
     *              default="123456",
     *      ),
     *    @SWG\Response(response=200, description="Password sucessfully updated"),
     *    @SWG\Response(response=422, description="User not exists or User not activated"),
     *    @SWG\Response(response=401, description="Token is invalid / Token is expired")
     * )
     */



    /**
     * Update password for authorized users.
     *
     * @return json
     */
    public function updatePassword() {
        $userRules = ['email' => 'required', 'password' => 'required', ];
        $this->setRules($userRules);
        $this->_validate();
        $email = $this->request->email;
        $newPassword = bcrypt($this->request->password);
        if ($this->checkUserActivation($email)) {
            $this->collector->where('email', '=', $email)->update(['password' => $newPassword,'is_new_user' => 0]);
            return $this->getSuccessJsonResponse([], 'Password sucessfully updated', 200);
        } else {
            return $this->getErrorJsonResponse([], 'User not exists or User not activated', 422);
        }
    }
    /**
     * register users.
     *
     * @return json
     */
    public function register() {
        $userRules = ['email'=>'required|unique:collector,email|email', 'password' => 'required', 'name' => 'required', 'collector_id' => 'required', ];
        $this->setRules($userRules);
        $this->_validate();
        $collector = new Collector();
        $collector->name = $this->request->name;
        $collector->email = $this->request->email;
        $collector->collector_id = $this->request->collector_id;
        $collector->mobile_number = $this->request->mobile_number;
        $collector->password = bcrypt($this->request->password);
        $collector->save();
        return $this->getSuccessJsonResponse([], 'Collector registered', 200);
    }
    
    /**
     * @SWG\Post(
     *      path="/api/v1/changepassword",
     *      tags={"Change Password"},
     *      operationId="changePassword",
     *      summary="Change Password API",
     *      @SWG\Parameter(
     *              name="x-request-type",
     *              in="header",
     *              required=true,
     *              type="string",
     *              default="mobile",
     *      ),
     *      @SWG\Parameter(
     *              name="token",
     *              in="header",
     *              required=true,
     *              type="string",
     *              default="",
     *      ),
     *      @SWG\Parameter(
     *              name="email",
     *              in="formData",
     *              required=true,
     *              type="string",
     *              default="sujankumar.s@contus.in",
     *      ),
     *      @SWG\Parameter(
     *              name="password",
     *              in="formData",
     *              required=true,
     *              type="string",
     *              default="123456",
     *      ),
     *    @SWG\Response(response=200, description="Password sucessfully changed"),
     *    @SWG\Response(response=422, description="User not exists or User not activated"),
     *    @SWG\Response(response=401, description="Token is invalid / Token is expired")
     * )
     */

    /**
     * Update password for authorized users.
     *
     * @return json
     */
    public function changePassword() {
        $userRules = ['email' => 'required', 'password' => 'required', ];
        $this->setRules($userRules);
        $this->_validate();
        $emailId = $this->request->email;
        $changePassword = bcrypt($this->request->password);
        if ($this->checkUserActivation($emailId)) {
            $this->collector->where('email', '=', $emailId)->update(['password' => $changePassword]);
            return $this->getSuccessJsonResponse([], 'Password sucessfully changed', 200);
        } else {
            return $this->getErrorJsonResponse([], 'User not exists or User not activated', 422);
        }
    }


    /**
     * @SWG\Post(
     *      path="/api/v1/updateprofile",
     *      tags={"Update Profile"},
     *      operationId="updateProfile",
     *      summary="Update Profile API",
     *      @SWG\Parameter(
     *              name="x-request-type",
     *              in="header",
     *              required=true,
     *              type="string",
     *              default="mobile",
     *      ),
     *      @SWG\Parameter(
     *              name="token",
     *              in="header",
     *              required=true,
     *              type="string",
     *              default="",
     *      ),
     *      @SWG\Parameter(
     *              name="email",
     *              in="formData",
     *              required=true,
     *              type="string",
     *              default="sujankumar.s@contus.in",
     *      ),
     *      @SWG\Parameter(
     *              name="mobile_number",
     *              in="formData",
     *              required=true,
     *              type="number",
     *              default="9876543210",
     *      ),
     *      @SWG\Parameter(
     *              name="name",
     *              in="formData",
     *              required=true,
     *              type="number",
     *              default="Tom",
     *      ),
     *    @SWG\Response(response=200, description="Profile sucessfully updated"),
     *    @SWG\Response(response=422, description="User not exists or User not activated"),
     *    @SWG\Response(response=401, description="Token is invalid / Token is expired")
     * )
     */


    /**
     * Update user profile for authorized users.
     *
     * @return json
     */
    public function updatProfile() {
        $userRules = ['name' => 'required|Regex:/^[a-zA-Z][a-zA-Z0-9\ ._&\-\(\)\[\]]+$/', 'mobile_number' => 'numeric'];
        $this->setRules($userRules);
        $this->_validate();
        $email = $this->request->email;
        if ($this->checkUserActivation($email)) {
            $name = $this->request->name;
            $mobileNumber = $this->request->mobile_number;
            $this->collector->where('email', '=', $email)->update(['name' => $name], ['mobile_number' => $mobileNumber]);
            return $this->getSuccessJsonResponse([], 'Profile sucessfully updated', 200);
        } else {
            return $this->getErrorJsonResponse([], 'User not exists or User not activated', 422);
        }
    }



    /**
     * @SWG\Post(
     *   path="/api/v1/getprofile",
     *   tags={"Get Profile"},
     *   summary="Get User Profile",
     *   operationId="getuserProfile",
     *   @SWG\Parameter(
     *          name="x-request-type",
     *          in="header",
     *          required=true,
     *          type="string",
     *          default="mobile",
     *      ),
     *      @SWG\Parameter(
     *          name="token",
     *          in="header",
     *          required=true,
     *          type="string",
     *          default="",
     *      ),
     *      @SWG\Parameter(
     *          name="email",
     *          in="formData",
     *          required=true,
     *          type="string",
     *          default="sujankumar.s@contus.in",
     *      ),
     *      @SWG\Response(response=200, description="Profile sucessfully updated"),
     *      @SWG\Response(response=422, description="User not exists or User not activated"),
     *      @SWG\Response(response=401, description="Token is invalid / Token is expired")
     * )
     *
     */


    /**
     * get user Profile Details for authorized users.
     *
     * @return json
     */
    public function getProfile() {
        $userRules = ['email' => 'required', ];
        $this->setRules($userRules);
        $this->_validate();
        $email = $this->request->email;
        if ($this->checkUserActivation($email)) {
            $data = $this->collector->where('email', '=', $email)->select('name', 'collector_id', 'mobile_number')->get();
            return $this->getSuccessJsonResponse(['data' => $data], 'Profile sucessfully updated', 200);
        } else {
            return $this->getErrorJsonResponse([], 'User not exists or User not activated', 422);
        }
    }
    /**
     * Check User is Activation.
     *
     * @return json
     */
    public function checkUserActivation($email = '', $mobile_number = '') {
        if ($email) {
            $user = $this->collector->where('email', '=', $email)->where('is_active', '=', 1)->first();
            if ($user) {
                $value =  $user;
            } else {
                $value = false;
            }
            return  $value;
        } else {
            $user = $this->collector->where('mobile_number', '=', $mobile_number)->where('is_active', '=', 1)->first();
            if ($user) {
                $value =  $user;
            } else {
                 $value = false;
            }
        }
        return $value;
    }


    /**
     * @SWG\Post(
     *      path="/api/v1/auth/forgotpassword",
     *      tags={"Forgot Password"},
     *      operationId="forgotpassword",
     *      summary="Forgot Password API",
     *      @SWG\Parameter(
     *              name="x-request-type",
     *              in="header",
     *              required=true,
     *              type="string",
     *              default="mobile",
     *      ),
     *      @SWG\Parameter(
     *              name="email",
     *              in="formData",
     *              required=true,
     *              type="string",
     *              default="sujankumar.s@contus.in",
     *      ),
     *    @SWG\Response(response=200, description="Forgot password email sucessfully send"),
     * )
     */


     /**
     * Function to to send Forgot Password
     * it will takes the email and password as input and update the password and  returns the response
     *
     * @return json object
     */
    
    public function sendForgotPassword() {
        $email = $this->request->email;
        $collector =(new Collector())->where('email', $email)->where('is_active', '=', 1)->first();
        if($collector){
        $settings= $this->setting->where('setting_name','collector_default_password')->select('setting_value')->first();
        (new Collector())->where('email', '=', $email)->update(['password' => bcrypt($settings->setting_value)]);
        return $this->sendEmail($collector->name,$email,$settings->setting_value);
        }
        else{
            return $this->getErrorJsonResponse([], 'User not exists or User not activated', 422);
        }
    }

    /**
     * Get the Email template contents
     * 
     * @param string $slug            
     * @return array
     */
    public function getEmailTemplate($slug) {
        $this->emailTemplate = new EmailTemplate ();
        $emailTemplate = $this->emailTemplate->where ( 'slug', $slug )->get ()->toArray ();
        return array_shift ( $emailTemplate );
    }

    /**
     * Send Password Reset Link to the User
     */

    public function sendEmail($name,$email,$password){
       $templateData = $this->getEmailTemplate ( 'collector-forgot-password' );
            if (isset ( $templateData )) {
                $logoImage = url('/').'/assets/images/Atlaslogo.png';
                $logolink = url('/');
                $subject = $templateData ['subject'];
                $emailContent = $templateData ['body'];  
                $emailContent = str_replace ( array (
                        '{{LOGO}}',
                        '{{LOGOURL}}',
                        '{{USER}}',
                        '{{EMAIL}}',
                        '{{PASSWORD}}' 
                ), array (
                        $logoImage,
                        $logolink,
                        $name,
                        $email,
                        $password 
                ), $emailContent );
                return $this->sendforgotPasswordEmail ( $email, $emailContent, $subject );

            } else {
                return $this->getErrorJsonResponse([], 'Email data is not available', 422);
            }
}

    /**
     * Function to send the email notification
     *
     * @return array
     */
    public function sendforgotPasswordEmail($email, $emailContent, $subject) {
        $fromEmail = env('MAIL_USERNAME');
        try {
            $responce = app ( 'mailer' )->send ( [ ], [ ], function ($message) use ($fromEmail, $email, $subject, $emailContent) {
            $message->to ( $email )->from ( $fromEmail, 'Atlas Copco' )->subject ( $subject )->setBody ( $emailContent, 'text/html' );
        } );

        } catch (Exception $e) {
           $responce = $e;
            
        }
        if ($responce   ===NULL) {
            return $this->getSuccessJsonResponse([], 'Forgot password email sucessfully send', 200);
        }else{
             return $this->getErrorJsonResponse([], 'Forgot password email not able to send', 422);
        }

}

}
