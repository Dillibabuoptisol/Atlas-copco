<?php

/**
 * Admin Repository
 *
 * To manage admin users related actions.
 *
 * @name       AdminRepository
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Repositories;

use Admin\Models\AdminUser;
use Contus\Base\Repositories\Repository;

class AdminRepository extends Repository {
  /**
   * Class initializer
   *
   * @return void
   */
  public function __construct() {
    parent::__construct ();
    $this->user = new AdminUser ();
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
  public function addOrUpdateAdminUser($requestData, $id = null) {
    /**
     * define the validation rules for users registration and
     * for profile update
     *
     * @var array $userRules
     */
    if (empty ( $id ) && is_null ( $id )) {
      $userRules = [ 
          'name' => 'required|Regex:/^[a-zA-Z][a-zA-Z0-9\ ._&\-\(\)\[\]]+$/',
          'email' =>'required|unique:admin_users,email|email',
          'password' => 'required',
          'confirm_password' => 'required|same:password',
          'mobile_number' => COMMON_MOBILE_VALIDATION_RULE . '|unique:admin_users,mobile_number|numeric|max:20|min:20'
      ];
    } else {
      $userRules = [ 
          ID => COMMON_NUMBER_VALIDATION_RULE . '|exists:admin_users,id' 
      ];
    }
    $this->setRules ( $userRules );
    $this->_validate ();
    $status = false;
    $userID = (isset ( $this->request->user_id )) ? $this->request->user_id : 1;
    if (! empty ( $id )) {
      $adminUser = AdminUser::find ( $id );
      $adminUser->updator_id = $userID;
    } else {
      $adminUser = new AdminUser ();
      $adminUser->password = bcrypt ( $this->request->password );
      $adminUser->access_token = md5 ( time () . $this->request->email );
      $adminUser->mobile_number = $this->request->mobile_number;
      $adminUser->email = $this->request->email;
    }
    $adminUser->creator_id = $userID;
    $adminUser->updator_id = $userID;
    $adminUser->name = $this->request->name;
    $adminUser->user_role_id = $this->request->user_role_id;
    $adminUser->profile_image = $this->request->profile_image;
    if ($adminUser->save ()) {
      $status = true;
    }
    return $status;
  }
  /**
   * Prepare the grid
   * set the grid model and relation model to be loaded
   *
   * @return \Contus\Base\Repositories\Repository
   */
  public function prepareGrid() {
   $this->setGridModel ( $this->user );
    return $this;
  }
  /**
   * This method is use to soft delete the records
   *
   * @see \Contus\Base\Contracts\ResourceInterface::destroy()
   *
   * @return bool
   */
  public function destroy() {
    $id = $this->request->id;
    return $this->user->where ( ID, $id )->update ( array (
        IS_ACTIVE => '0' 
    ) );
  }
  
  /**
   * Update grid records collection query
   *
   * @param mixed $builder          
   * @return mixed
   */
  protected function updateGridQuery($adminUser) {
    /**
     * updated the grid query by using this function and apply the video condition.
     */
    $filters = $this->request->input('filters');
    if (! empty ( $filters )) {
      foreach ( $filters as $key => $value ) {
        switch ($key) {
          case 'name' :
            $adminUser->where ( 'name', 'like', '%' . $value . '%' )->get ();
            break;
          case 'mobile_number' :
            $adminUser->where ( 'mobile_number', 'like', '%' . $value . '%' )->get ();
            break;
          case 'email' :
            $adminUser->where ( 'email', 'like', '%' . $value . '%' )->get ();
            break;
          case 'status' :
            if ($value != 'All') {
              $adminUser->where ( 'is_active', $value );
            }
            break;
          case 'dateRange':
            $value = explode('-',trim($value));
            $value[1] = date("Y-m-d", strtotime("+1 day",strtotime($value[1])));
            $adminUser->whereBetween('created_at', [date("Y-m-d", strtotime($value[0])), date("Y-m-d", strtotime($value[1]))]);  
            break;
          default :
            $adminUser->where ( $key, 'like', "%$value%" );
            break;
        }
      }
    }
    return $adminUser;
  }
  
  /**
   * Method to pass additional information to the grid
   *
   * @see \Contus\Base\Contracts\GridableInterface::getGridAdditionalInformation()
   */
  public function getGridAdditionalInformation() {
    $activeAdminUsers = $this->user->where ( 'is_active', 1 )->count ();
    $inactiveAdminUsers = $this->user->where ( 'is_active', 0 )->count ();
    $totalAdminUsers = $this->user->count ();
    return [
    'activeCount' => $activeAdminUsers,
    'inactiveCount' => $inactiveAdminUsers,
    'totalCount' => $totalAdminUsers,
    ];
  }
}