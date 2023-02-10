<?php
/**
 * PasswordController
 *
 * Change the password of the customer
 *
 * @name       PasswordController
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Http\Controllers\Web;

use Admin\Repositories\Web\PasswordRepository;

class PasswordController extends WebController {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PasswordRepository $userRepository) {
        parent::__construct ();
        $this->repository = new PasswordRepository ();
        $this->repository->setRequestType ( 'HTTP' );
        view ()->share ( 'includeAngularNotification', false );
    }
    
    /**
     * Method to get the change password index.
     *
     * @return \Illuminate\Http\View
     */
    public function getchangePassword() {
        return view ( 'changepassword.index' );
    }
    
    /**
     * To change the password
     * 
     * @return json response
     */
    public function changePassword() {
        $response = $this->repository->changePassword ();
        return ($response) ? redirect ( 'changepassword' )->with ( 'password', 'Password updated successfully' ) : back()->withErrors(['old_password' => trans('general.old_password_error')])->withInput();
    }
}