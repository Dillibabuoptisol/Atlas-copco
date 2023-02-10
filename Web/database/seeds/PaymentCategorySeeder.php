<?php

use Illuminate\Database\Seeder;
use Admin\Models\PaymentCategory;
class PaymentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_category')->delete();
		DB::unprepared("ALTER TABLE payment_category AUTO_INCREMENT = 1;");
		$payment_category = [
				'1' => [
						'category_name' => 'Equipment',
						'is_active'=>1
				],
				'2' => [
						'category_name' => 'CTS',
						'is_active'=>1
				],
				'3' => [
						'category_name' => 'Advance',
						'is_active'=>1
				]
		];
		foreach ( $payment_category as $key => $value ) {
			PaymentCategory::create ( [
					'id' => $key,
					'category_name' => $value ['category_name'],		
					'is_active' => $value ['is_active'],		
				] );
		}
	}
}
