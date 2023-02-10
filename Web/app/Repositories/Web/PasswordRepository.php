<?php
/**
 * Password Repository
 *
 * To manage Passwords related actions.
 *
 * @name       MoverBee
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Repositories\Web;

use Contus\Base\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Customer\Models\User;
use Contus\Base\Exceptions\InvalidRequestException;

class PasswordRepository extends Repository {
    
    /**
     * To change the password
     *
     * @throws InvalidRequestException
     * @return boolean
     */
    public function changePassword() {
        $this->rules = array (
                'old_password' => 'required',
                'new_password' => 'required|different:old_password',
                'confirm_password' => 'required|same:new_password' 
        );
        $this->setRules ( $this->rules );
        $this->validate ( $this->request, $this->getRules () );
        try {
            $user = \Admin\User::findorfail ( auth ()->user ()->id );
            if (Hash::check ( $this->request->old_password, $user->password )) {
                $user->password = Hash::make ( $this->request->new_password );
                $user->save ();
                return true;
            } else {
                return false;
            }
        } catch ( Exception $e ) {
            throw new InvalidRequestException ( 'Unable to process', 500 );
        }
    }
}