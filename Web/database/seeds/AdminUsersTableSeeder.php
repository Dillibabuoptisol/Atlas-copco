<?php

use Illuminate\Database\Seeder;
use Admin\Models\AdminUser;

class AdminUsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('admin_users')->delete();
		DB::unprepared("ALTER TABLE admin_users AUTO_INCREMENT = 1;");
		$adminUsers = [
				'1' => [
						'name' => 'sujan',
						'email' => 'sujankumar.s@contus.in',
						'forgot_password_token' => '',
						'password' =>  Hash::make ("admin123"),
						'mobile_number'=>9876543210,
						'access_token'=>bcrypt('12334'),
						'is_verified'=>1,
						'is_active'=>1,
						'creator_id'=>'1',
						'updator_id'=>'1'
				],
				'2' => [
						'name' => 'Ramesh',
						'email' => 'ramesh.b@contus.in',
						'forgot_password_token' => '',
						'password' =>  Hash::make ("admin123"),
						'mobile_number'=>9876543210,
						'access_token'=>bcrypt('12334'),
						'is_verified'=>0,
						'is_active'=>1,
						'creator_id'=>'1',
						'updator_id'=>'1'
				]
		];
		foreach ( $adminUsers as $key => $value ) {
			AdminUser::create ( [
					'id' => $key,
					'name' => $value ['name'],
					'email' => $value ['email'],
					'password' => $value ['password'],
					'mobile_number'=>$value ['mobile_number'],
					'access_token'=>$value ['access_token'],
					'is_verified'=>$value ['is_verified'],
					'is_active' => $value ['is_active'],
					'creator_id' => $value ['creator_id'],
					'updator_id' => $value ['updator_id'],
			] );
		}
	}
}