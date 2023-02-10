<?php
/**
 * MyprofileRepository for web
 *
 * To manage admin users related actions.
 *
 * @name       MyprofileRepository Web Interface
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Repositories\Web;

use Admin\Repositories\MyprofileRepository as AdminBaseRepository;
use Admin\Models\UserRole;
use Admin\Models\AdminUser;
use Illuminate\Support\Facades\Hash;

class MyprofileRepository extends AdminBaseRepository {
    /**
     * Class initializer
     *
     * @return void
     */
    public function __construct() {
        parent::__construct ();
        $this->user = new AdminUser();
        $this->userRole = new UserRole();
        $profileRules = array (
                'name' => 'required|max:30|Regex:/^[a-zA-Z][a-zA-Z0-9\ ._&\-\(\)\[\]]+$/',
                'email' => 'required|unique:admin_users,email|email',
                'mobile_number' => 'required|numeric|min:10|max:12',
                'user_role' => 'required|exists:user_roles,id',
                'employee_id' => 'required|min:1|max:20',
                'department' => 'required' 
        );
        $this->setRules ( $profileRules );
    }
    /**
     * Method to get rules, city, state and country for adding users for admin.
     *
     * @return array
     */
    public function create() {
        return array (
                'rules' => $this->getRules (),
                'userRoles' => $this->userRole->where ( 'is_active', 1 )->get () 
        );
    }
    /**
     * Method to fetch single info of a admin user
     *
     * @param int $profileId            
     * @return array
     */
    public function edit($profileId) {
        return array (
                'id' => $profileId,
                'myProfileSingleInfo' => $this->user->where ( 'id', $profileId )->first (),
                'rules' => $this->getRules (),
                'userRoles' => $this->userRole->where ( 'is_active', 1 )->get () 
        );
    }
    /**
     * This method is use to save the data in admin user tables
     *
     * @see \Contus\Base\Contracts\ResourceInterface::store()
     *
     * @return boolean
     */
    public function store() {
        return $this->addOrUpdateAdminUser ( $this->request->all () );
    }
    
    /**
     * This method is use to update the admin user details based on the user id
     *
     * @see \Contus\Base\Contracts\ResourceInterface::update()
     * @return boolean
     */
    public function update() {
        return $this->addOrUpdateAdminUser ( $this->request->all (), $this->request->id );
    }
    /**
     * This method is use as a common method for both store and update.
     *
     * @param array $requestData            
     * @param int $id            
     * @return boolean
     */
    public function addOrUpdateAdminUser($requestData, $profileId = null) {
        $userID = (isset ( $this->request->user_id )) ? $this->request->user_id : 1;
        if (! empty ( $profileId )) {
            $user = $this->user->findOrFail ( $profileId );
            $this->setRule ( 'name', 'required|max:50' );
            $this->setRule ( 'email', 'required|unique:admin_users,email,' . $user->id . '|email' );
            $this->setRule ( 'mobile_number', 'required|numeric' );
        } else {
            $user = $this->user;
            $user->verification_code = Hash::make ( str_random ( 10 ) );
        }
        $this->_validate ();
        $user->fill ( $this->request->all (), array (
                $user->creator_id = $userID,
                $user->updator_id = $userID,
                $user->user_role_id = $this->request->user_role,
                $user->access_token = '' 
        ) );
        $user->user_role_id = $this->request->user_role;
        if (isset ( $this->request->uploadedImage )) {
            $user->profile_image = $this->request->uploadedImage;
        }
        if ($user->save ()) {
            $status = true;
        }
        return $status;
    }
}