<?php
/**
 * Admin Repository for web
 *
 * To manage admin users related actions.
 *
 * @name       AdminRepository Web Interface
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Repositories\Web;

use Admin\Repositories\AdminRepository as AdminBaseRepository;
use Illuminate\Contracts\Validation\Factory;
use Admin\Models\EmailTemplate;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Hash;
use Contus\Base\Repositories\Repository;
use Admin\User;
use Admin\Events\SendMail;
use Event;

class AdminRepository extends AdminBaseRepository {
    /**
     * Class initializer
     *
     * @return void
     */
    public function __construct() {
        parent::__construct ();
        $this->setRules ( array (
                'name' => 'required|max:30|unique:admin_users,name|Regex:/^[a-zA-Z][a-zA-Z0-9\ ._&\-\(\)\[\]]+$/',
                'email' => 'required|unique:admin_users,email|email',
                'mobile_number' => 'required|unique:admin_users,mobile_number|numeric|min:6|max:15',
        ) );
    }
    /**
     * Method to get rules, city, state and country for adding users for admin.
     *
     * @return array
     */
    public function create() {
        $newRules = $this->getRules ();
        $newRules ['password'] = 'required|min:6';
        return array (
                'rules' => $newRules
        );
    }
    /**
     * Method to fetch single info of a admin user
     *
     * @param int $id            
     * @return array
     */
    public function edit($id) {
        return array (
                'id' => $id,
                'adminUserSingleInfo' => $this->user->where ( 'id', $id )->select('id','name','email','mobile_number','is_active')->first (),
                'rules' => $this->getRules ()
        );
    }
    /**
     * This method is use as a common method for both store and update.
     *
     * @param array $requestData            
     * @param int $id            
     * @return boolean
     */
    public function addOrUpdateAdminUser($requestData, $id = null) {
         $userID = $this->request->has('id') ? $this->request->get('id') : 1;
        $user = $this->user->findOrNew($id);
        if (! empty ( $id )) {
            $this->setRule ( 'name', 'required|unique:admin_users,name,' . $user->id . '|max:30' );
            $this->setRule ( 'email', 'required|unique:admin_users,email,' . $user->id . '|email' );
            $this->setRule ( 'mobile_number', 'required|unique:admin_users,mobile_number,' . $user->id . '|numeric' );
                $user->fill ( $this->request->all (), array (
                $user->creator_id = $userID,
                $user->updator_id = $userID,
                $user->is_active = $this->request->is_active,
                $user->access_token = '',
        ) );
        } else {
            $user = new User();
            $this->setRules([
          'name' => 'required|Regex:/^[a-zA-Z][a-zA-Z0-9\ ._&\-\(\)\[\]]+$/' . $user->id . '|max:30',
          'email' =>'required|unique:admin_users,email,' . $user->id . '|email',
          'mobile_number' =>'required|unique:admin_users,mobile_number,' . $user->id . '|numeric',
         ])->_validate();
         $user->verification_code = Hash::make ( str_random ( 10 ) );
         $user->email =  $this->request->email;
         $user->is_active = $this->request->is_active;
         $user->mobile_number = $this->request->mobile_number;
         $user->name = $this->request->name;
         $user->password = bcrypt ( $this->request->password );
         $user->access_token = '';
         $user->creator_id = $userID;
         $user->updator_id = $userID;
        }
        $this->validateData ( $this->request->toArray (), $this->getRules () );
        
     if (! empty ( $this->request->password ) && empty ( $id )) {
        $this->emailTemplate = new EmailTemplate ();
        $email = $this->request->email;
        $password = $this->request->password;
        $name = $this->request->name;
        $logoImage = url('/').'/assets/images/Atlaslogo.png';
        $logolink = url('/');
        $emailContent = trans ( 'general.email' ) . ": " . $email . trans ( 'general.password' ) . ": " . $password;
            $templateData = $this->getEmailTemplate ( 'admin_registration' );
            if (isset ( $templateData )) {
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
              $this->sendEmailNotification ( $email, $emailContent, $subject );
            } 
          
        }

        if ($user->save ()) {
            $status = true;
        }
        return $status;
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
     * Function to send the email notification
     *
     * @return array
     */
    public function sendEmailNotification($email, $emailContent, $subject){
        $fromEmail = env('MAIL_USERNAME');
        app ( 'mailer' )->send ( [ ], [ ], function ($message) use ($fromEmail, $email, $subject, $emailContent) {
            $message->to ( $email )->from ( $fromEmail, 'Atlas Copco' )->subject ( $subject )->setBody ( $emailContent, 'text/html' );
        } );
    }
    
    /**
     * Validate data
     *
     * @param array $data            
     * @param array $validationRules            
     * @return boolean
     */
    public function validateData(array $data, $validationRules) {
        return app ( Factory::class )->make ( $data, $validationRules );
    }
}