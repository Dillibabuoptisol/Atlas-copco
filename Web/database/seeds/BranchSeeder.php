<?php

use Illuminate\Database\Seeder;
use Admin\Models\Branches;
class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branches')->delete();
		DB::unprepared("ALTER TABLE branches AUTO_INCREMENT = 1;");
		$branches = [
				'1' => [
						'branch_name' => 'Jeddah',
						'is_active'=>1
				],
				'2' => [
						'branch_name' => 'Riyadh',
						'is_active'=>1
				],
				'3' => [
						'branch_name' => 'Khobar',
						'is_active'=>1
				],
				'4' => [
						'branch_name' => 'Kuwait',
						'is_active'=>1
				]
		];
		foreach ( $branches as $key => $value ) {
			Branches::create ( [
					'id' => $key,
					'branch_name' => $value ['branch_name'],
					'is_active'=> $value['is_active']		
				] );
		}
	}
}
