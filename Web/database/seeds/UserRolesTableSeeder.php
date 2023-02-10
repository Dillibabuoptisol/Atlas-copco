<?php

use Illuminate\Database\Seeder;
use Admin\Models\UserRole;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('user_roles')->delete();
    	DB::table ( 'settings' )->delete ();
    	DB::table ( 'setting_categories' )->delete ();
    	DB::unprepared("ALTER TABLE user_roles AUTO_INCREMENT = 1;");
    	$adminUserRoles = [
    			1 => [
    					'name'=>'Super Admin',
    					'slug' => 'super-admin',
    					'is_active'=>'1',
    					'creator_id'=>'1',
    					'updator_id'=>'1',
    					'permission' => [
    							"Create" => true,
    							"Delete" => true,
    							"View"   => true,
    							"Update" => true
    					]
    			],
    			2 => [
    					'name'=>'Admin',
    					'slug' => 'admin',
    					'is_active'=>'1',
    					'creator_id'=>'1',
    					'updator_id'=>'1',
    					'permission' => [
    							"Create" => true,
    							"Delete" => false,
    							"View"   => true,
    							"Update" => true
    					],
    			],
    			3 => [
    					'name'=>'User',
    					'slug' => 'user',
    					'is_active'=>'1',
    					'creator_id'=>'1',
    					'updator_id'=>'1',
    					'permission' => [
    							"Create" => false,
    							"Delete" => false,
    							"View"   => true,
    							"Update" => false
    					],
    			],
    	];
    	foreach ( $adminUserRoles as $key => $value ) {
    		UserRole::create ( [
    				'id' => $key,
    				'name' => $value ['name'],
    				'slug' => $value ['slug'],
    				'permissions' => json_encode($value ['permission']),
			        'is_active' => $value ['is_active'],
			        'creator_id' => $value ['creator_id'],
			        'updator_id' => $value ['updator_id'],
    		] );
    	}
    }
}
