<?php

use Illuminate\Database\Seeder;
use Admin\Models\PaymentType;
class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
	{
		DB::table('payment_type')->delete();
		DB::unprepared("ALTER TABLE payment_type AUTO_INCREMENT = 1;");
		$payment_type = [
				'1' => [
						'payment_name' => 'Cash',
						'is_active'=>1
				],
				'2' => [
						'payment_name' => 'Cheque',
						'is_active'=>1
				],
				'3' => [
						'payment_name' => 'Bank Transfer',
						'is_active'=>1
				]
		];
		foreach ( $payment_type as $key => $value ) {
			PaymentType::create ( [
					'id' => $key,
					'payment_name' => $value ['payment_name'],
					'is_active' => $value ['is_active']			
				] );
		}
	}
}
