<?php

/**
 * Role Repository
 *
 * To manage admin roles related actions.
 *
 * @name       RoleRepository
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Repositories;

use Admin\Models\UserRole;
use Admin\Models\AdminUser;
use Contus\Base\Repositories\Repository;

class RoleRepository extends Repository {
  /**
   * Class initializer
   *
   * @return void
   */
  public function __construct(AdminUser $adminUser, UserRole $userRoles) {
    parent::__construct ();
    $this->user = $adminUser;
    $this->userRole = $userRoles;
    $this->setRules ( array (
        'name' => 'required|unique:user_roles,name,null,id,is_active,1|max:50' 
    ) );
  }
  /**
   * Method to fetch rules for the userrole
   *
   * @return array, rules
   */
  public function create() {
    return array (
        'rules' => $this->getRules (),
    );
  }
  /**
   * Method to fetch rules, single role info
   *
   * @param int $id          
   *
   * @return array
   */
  public function edit($id) {
    return array (
        'id' => $id,
        'rules' => $this->getRules (),
        'adminRoleSingleInfo' => $this->userRole->where ( 'id', $id )->first () 
    );
  }
  /**
   * This method is use to save the data in user roles tables
   *
   * @see \Contus\Base\Contracts\ResourceInterface::store()
   *
   * @return boolean
   */
  public function store() {
    return $this->addOrUpdate ( $this->request->all () );
  }
  /**
   * This method is use to update the roles details based on the role id
   *
   * @see \Contus\Base\Contracts\ResourceInterface::update()
   * @return boolean
   */
  public function update() {
    return $this->addOrUpdate ( $this->request->all (), $this->request->id );
  }
  
  /**
   * This method is use as a common method for both store and update.
   *
   *
   * @param array $requestData          
   * @param int $id          
   * @return boolean
   */
  public function addOrUpdate($requestData, $id = null) {
    if (! empty ( $id )) {
      $userRoles = $this->userRole->find ( $id );
      $this->setRule ( 'name', 'required|unique:user_roles,name,' . $userRoles->id . '|max:50' );
    } else {
     $userRoles = $this->userRole;
    }
    $this->_validate();
    $permissions = $this->request->permissions;
    $permissionSet = array (
        'Create',
        'Delete',
        'View',
        'Update' 
    );
    $permissionTrue = [ ];
    $permissionFalse = [ ];
    foreach ( $permissionSet as $value ) {
      if (in_array ( $value, $permissions )) {
        $permissionTrue [$value] = true;
      } else {
        $permissionFalse [$value] = false;
      }
    }
    $finalPermissions = array_merge ( $permissionTrue, $permissionFalse );
    $finalPermissions = json_encode ( $finalPermissions );
    $userID = (isset ( $this->request->user_id )) ? $this->request->user_id : 1;
    $userRoles->name = $this->request->name;
    $userRoles->permissions = $finalPermissions;
    $userRoles->slug = str_slug ( $this->request->name );
    $userRoles->is_active = $this->request->is_active;
    $userRoles->creator_id = $userID;
    $userRoles->updator_id = $userID;
    $userRoles->save ();
    return true;
  }
  /**
   * Prepare the grid
   * set the grid model and relation model to be loaded
   *
   * @return \Contus\Base\Repositories\Repository
   */
  public function prepareGrid() {
    $this->setGridModel ( $this->userRole );
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
    $returnStatus = true;
    $getUsers = $this->user->where ( 'user_role_id', $id )->where ( IS_ACTIVE, 1 )->count ();
    if ($getUsers == '0') {
      $this->userRole->where ( ID, $id )->update ( array (
          IS_ACTIVE => '0' 
      ) );
    } else {
      $returnStatus = false;
    }
    
    return $returnStatus;
  }
  /**
   * Method to pass additional information to the grid
   *
   * @see \Contus\Base\Contracts\GridableInterface::getGridAdditionalInformation()
   */
  public function getGridAdditionalInformation() {
    $activeRoles = $this->userRole->where ( 'is_active', 1 )->count ();
    $inactiveRoles = $this->userRole->where ( 'is_active', 0 )->count ();
    $totalRoles = $this->userRole->count ();
    return [ 
        'activeCount' => $activeRoles,
        'inactiveCount' => $inactiveRoles,
        'totalCount' => $totalRoles 
    ];
  }
  /**
   * Update grid records collection query
   *
   * @param mixed $roles          
   * @return mixed
   */
  protected function updateGridQuery($roles) {
    $filters = $this->request->input('filters');
    if (! empty ( $filters )) {
      foreach ( $filters as $key => $value ) {
        switch ($key) {
          case 'name' :
            $roles->where ( 'name', 'like', '%' . $value . '%' )->get ();
            break;
          case 'tab' :
          case 'status' :
            if ($value != 'All') {
              $roles->where ( IS_ACTIVE, $value );
            }
            break;
          case 'created_at' :
           $createdAt = explode('-', $value);
           $roles->whereBetween('created_at', array($createdAt[0], $createdAt[1]))->get();
           break;
          default :
            $roles->where ( $key, 'like', "%$value%" );
            break;
        }
      }
    }
    
    return $roles;
  }
}