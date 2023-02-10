<?php
/**
 * AdminGroup Repository
 *
 * To manage admin group related actions.
 *
 * @name       AdminGroupRepository
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Repositories;

use Admin\Models\UserRole;
use Admin\Models\AdminUser;
use Admin\Models\AdminUserGroup;
use Admin\Models\AdminGroup;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Contus\Base\Repositories\Repository;

class AdminGroupRepository extends Repository {
/**
 * Class initializer
 *
 * @return void
 */
public function __construct(AdminUser $adminUser, AdminGroup $adminGroups, AdminUserGroup $adminUserGroups) {
 parent::__construct ();
 $this->user = $adminUser;
 $this->adminGroups = $adminGroups;
 $this->adminUserGroups = $adminUserGroups;
}

/**
 * This method is use to save the data in admin user tables
 * 
 * @see \Contus\Base\Contracts\ResourceInterface::store()
 * 
 * @return boolean
 */
public function store() {
 return $this->addOrUpdateAdminGroup ( $this->request->all () );
}

/**
 * This method is use to update the admin user details based on the user id
 *
 * @see \Contus\Base\Contracts\ResourceInterface::update()
 * 
 * @return boolean
 */
public function update() {
 return $this->addOrUpdateAdminGroup ( $this->request->all (), $this->request->id );
}

/**
 * This method is use as a common method for both store and update.
 *
 * @param array $requestData         
 * @param int $id         
 * @return boolean
 */
public function addOrUpdateAdminGroup($requestData, $id = null) {
 if (! empty ( $id )) {  
  $groupId = $this->adminGroups->find ( $id );
  $this->setRule ( 'name', 'required|unique:admin_groups,name,' . $groupId->id . '|max:50' );  
 } else {
  $groupId = $this->adminGroups;
  $this->setRule ( 'name', 'required|unique:admin_groups,name|max:50' );
 }
 $this->setRule ( 'admin_user_id', 'required' );
 $this->setRule ( 'is_active','required|numeric' );
 $this->validate ( $this->request, $this->getRules () );
 $groupId->fill ( $this->request->except ( '_token', 'admin_user_id' ) );
 $groupId->is_active = $this->request->is_active;
 $groupId->creator_id = $this->request->user_id;
 $groupId->updator_id = $this->request->user_id;
 if ($groupId->save ()) {
  $count = $this->adminUserGroups->where ( GROUP_ID, $groupId->id )->count ();
  if ($count > 0) {
   $this->adminUserGroups->where ( GROUP_ID, $groupId->id )->delete ();
  }
  $this->addUserGroupInfo ( $groupId->id, $this->request->admin_user_id );
 }
 return true;
}
/**
 * Function to add the user groups
 *
 * @param int $groupID         
 * @param string $userIDLists         
 * @return boolean
 */
public function addUserGroupInfo($groupID, $userIDLists) {
 $userIDLists = explode ( ',', $userIDLists );
 foreach ( $userIDLists as $userID ) {
  if (AdminUser::find ( $userID )) {
   $userRole = new AdminUserGroup ();
   $userRole->user_id = $userID;
   $userRole->group_id = $groupID;
   $userRole->save ();
  }
 }
 return true;
}
/**
 * Prepare the grid
 * set the grid model and relation model to be loaded
 *
 * @return \Contus\Base\Repositories\Repository
 */
public function prepareGrid() {
 $this->setGridModel ( $this->adminGroups );
 return $this;
}

/**
 * Update grid records collection query
 *
 * @param mixed $builder         
 * @return mixed
 */
protected function updateGridQuery($builder) {
 /**
  * updated the grid query by using this function and apply the video condition.
  */
 $builder->where ( IS_ACTIVE, 1 );
 return $builder;
}

/**
 * This method is use to delete the records from the admin group table and
 * it's sub table admin user group table
 * 
 * @see \Contus\Base\Contracts\ResourceInterface::destroy()
 * 
 * @return bool
 */
public function destroy() {
 $id = $this->request->id;
 $count = $this->adminUserGroups->where ( GROUP_ID, $id )->count ();
 if ($count > 0) {
  $this->adminUserGroups->where ( GROUP_ID, $id )->delete();
 }
 return $this->adminGroups->where ( ID, $id )->update ( array (
  IS_ACTIVE => '0' 
 ) );
}

}