<?php
/**
 * User Repository
 *
 * To manage user related actions.
 *
 * @name       UserRepository
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
/**
 * Including dependency classes
 * models, repositories, laravel default libraries
 */
namespace Admin\Repositories;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Admin\User;
use Admin\Models\EmailTemplate;
use Admin\Models\Setting;
use Illuminate\Auth\Access\Response;
use Contus\Base\Repositories\Repository;
use URL;
use Illuminate\Support\Facades\Mail;

class UserRepository extends Repository {
    /**
     * Class initializer
     *
     * @return void
     */
    public function __construct(User $user) {
        parent::__construct ();
        $this->user = $user;
        $this->settings = new Setting ();

    }
    
    /**
     * this function is used to check if the user is authenticated or it will takes the email and password as input
     *
     * @return json response
     */
    public function checkLogin() {
        $response = [ 
                'status' => false,
                'code' => 422 
        ];
        $this->setRules ( [ 
                EMAIL => 'required|email',
                PASSWORD => 'required' 
        ] );
        $this->_validate ();
        $user = $this->user->where ( EMAIL, $this->request->email )->first ();
        
        if (count ( $user ) > 0) {
            if (Hash::check ( $this->request->password, $user->password )) {
                $response ['status'] = true;
                auth ()->loginUsingId ( $user->id );
                $response = $this->checkUserStatus ();
            } else {
                $response [MESSAGE] = trans ( 'user.login.invalid-password' );
            }
        } else {
            $response [MESSAGE] = trans ( 'user.login.invalid-email' );
        }
        return $response;
    }
    
    /**
     * This function is used to check if user account is active or not
     *
     * @return array Response
     */
    protected function checkUserStatus() {
        $response = '';
        if (auth ()->user ()->is_active == 1) {
            if (auth ()->user ()->is_verified == 1) {
                $response = [ 
                        STATUS => true,
                        MESSAGE => trans ( 'user.login.success' ),
                        'adminusers' => auth ()->user () 
                ];
            } else {
                $response = [ 
                        STATUS => true,
                        MESSAGE => trans ( 'user.login.invalid-authorise' ),
                        'adminusers' => auth ()->user () 
                ];
            }
        } else {
            $response = [ 
                    STATUS => false,
                    MESSAGE => trans ( 'user.login.invalid-status' ),
                    'code' => 422 
            ];
        }
        return $response;
    }
    


        /**
     * This method used to send forgot password link to the register user
     */
    public function sendForgotPasswordLink(){
        $this->setRules(['email'=>'required']);
        $this->_validate();
        if($this->user->where('email','=',$this->request->email)->count() > 0){
           return  $this->updateForgotPasswordToken();
        }else{
            return $this->getErrorJsonResponse(['messages'=>['email'=>[0 =>'The email does not exists or waiting for approval']]], 'Unprocessable Entity',422);
        }
    }
    /**
     * This method used to update the forgot password token and send the
     * reset link to correstponding email
     * 
     */
    public function updateForgotPasswordToken(){
        $email = $this->request->email;
        $baseUrl = URL('/');
        $randString = $this->generateRandomString(20);
        $resetLink = $baseUrl.'/updatepassword/'.$randString;
        $isUpdated = $this->user->where('email','=',$email)->update([
            'forgot_password_token'=>$randString
        ]);
        if($isUpdated){
            $user = $this->user->where('email','=',$email)->first();
            $this->sendEmail($user->name,$email, $resetLink);
        }else{

            return $this->getErrorJsonResponse(['messages'=>['email'=>[0 =>'something went wrong please try again later']]], 'Unprocessable Entity',422);
        }
        
    }

    /**
     * Send Password Reset Link to the User
     */

    public function sendEmail($name,$email,$resetLink){
       $this->emailTemplate = new EmailTemplate ();
       $templateData = $this->getEmailTemplate ( 'password-reset' );
            if (isset ( $templateData )) {
                $subject = $templateData ['subject'];
                $emailContent = $templateData ['body'];
                $logoImage = url('/').'/assets/images/Atlaslogo.png';
                $logolink = url('/');
                $emailContent = str_replace ( array (
                        '{{LOGO}}',
                        '{{LOGOURL}}',
                        '{{USER}}',
                        '{{USER}}',
                        '{{URL}}'
                ), array (
                        $logoImage,
                        $logolink,
                        $name,
                        $name,
                        $resetLink,
                ),$emailContent );
            } else {
                $subject = trans ( 'general.atlascopco_changepassword' );
            }

            $this->sendEmailNotification ( $email, $emailContent, $subject );
}


    /**
     * Function to send the email notification
     *
     * @return array
     */
    public function sendEmailNotification($email, $emailContent, $subject) {
        $fromEmail=env('MAIL_USERNAME');
            try {
            $responce =app ( 'mailer' )->send ( [ ], [ ], function ($message) use ($fromEmail, $email, $subject, $emailContent) {
            $message->to ( $email )->from ( $fromEmail)->subject ( $subject )->setBody ( $emailContent, 'text/html' );
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
        /**
     * Get the Email template contents
     * 
     * @param string $slug            
     * @return array
     */
    public function getEmailTemplate($slug) {
        $emailTemplate = $this->emailTemplate->where ( 'slug', $slug )->get ()->toArray ();
        return array_shift ( $emailTemplate );
    }
    /**
     * To generate random string apend in the url
     */
    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    
        /**
     * To reset the Password
     */
    public function resetPassword(){
        $this->setRules([
            'password' => 'required|confirmed|min:6',
            'password_confirmation'=>'required',
            ]);
        $this->_validate();
        if($this->user->where('forgot_password_token','=',$this->request->token)->count() > 0){
            $this->user->where('forgot_password_token','=',$this->request->token)->update([
                'password'=>Hash::make ($this->request->password),
                'forgot_password_token'=>NULL
            ]);
            return $this->getSuccessJsonResponse([], 'Successfully updated',200);            
         }else{
            return $this->getErrorJsonResponse(['messages'=>['password'=>[0 =>'something went wrong please try again later']]], 'Unprocessable Entity',422);
        }
    }


}

