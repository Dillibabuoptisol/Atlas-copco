<?php

use Illuminate\Database\Seeder;
use Admin\Models\Collector;
class CollectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('collector')->delete();
		DB::unprepared("ALTER TABLE collector AUTO_INCREMENT = 1;");
		$collector = [
				'1' => [
						'name' => 'testaccount',
						'email' => 'test@contus.in',
						'collector_id' => '1',
						'password' =>  Hash::make ("123456"),
						'mobile_number' => 9876543210,
						'is_active' => '1',
				]
		];
		foreach ( $collector as $key => $value ) {
			Collector::create ( [
					'id' => $key,
					'name' => $value ['name'],		
					'email' => $value ['email'],		
					'collector_id' => $value ['collector_id'],		
					'password' => $value ['password'],		
					'mobile_number' => $value ['mobile_number'],		
					'is_active' => $value ['is_active'],		
				] );
		}
	}
}

