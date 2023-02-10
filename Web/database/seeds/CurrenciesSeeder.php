<?php

use Illuminate\Database\Seeder;
use Admin\Models\Currencies;
class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
		DB::table('currencies')->delete();
		DB::unprepared("ALTER TABLE currencies AUTO_INCREMENT = 1;");
		$currency = [
				'1' => [
						'currency_name' => 'SAR',
						'is_active'=>1
				],
				'2' => [
						'currency_name' => 'USD',
						'is_active'=>1
				],
				'3' => [
						'currency_name' => 'EURO',
						'is_active'=>1
				],
		];
		foreach ( $currency as $key => $value ) {
			Currencies::create ( [
					'id' => $key,
					'currency_name' => $value ['currency_name'],
					'is_active' => $value ['is_active']			
				] );
		}
	}
}
