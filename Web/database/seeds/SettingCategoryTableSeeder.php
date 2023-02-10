<?php
use Illuminate\Database\Seeder;
use Admin\Models\SettingCategory;
use Admin\Models\Setting;
class SettingCategoryTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table ( 'setting_categories' )->delete ();
		DB::table ( 'settings' )->delete ();
		// Auto increment value set to 1
		DB::unprepared ( "ALTER TABLE setting_categories AUTO_INCREMENT = 1;" );
		DB::unprepared ( "ALTER TABLE settings AUTO_INCREMENT = 1;" );

		$settingsCategories = [
				'1' => [
						'id' => 1,
						'name' => 'General Settings',
						'slug' => 'general-settings',
						'parent_id' => NULL
				],
				'2' => [
						'id' => 2,
						'name' => 'Accounts Team',
						'slug' => 'accounts-contact-information',
						'parent_id' => 1,
						'settings' => [
								[
										'setting_name' => 'accounts_team_email_address',
										'setting_value' => 'accountsteam@atlascopco.com',
										'display_name' => 'Accounts Team Email Address',
										'type' => 'text',
										'order' => 1,
										'setting_category_id' => 2,
										'description' => 'Enter accouts team email address with comma(,) separate'
								]
						]
				],
				'3' => [
						'id' => 3,
						'name' => 'Collecter Settings',
						'slug' => 'collecter-settings',
						'parent_id' => 1,
						'settings' => [
								[
										'setting_name' => 'collector_default_password',
										'setting_value' => '123456',
										'display_name' => 'Collector Default password',
										'type' => 'text',
										'order' => 1,
										'setting_category_id' => 3
								]
						]
				],
		];
		foreach ( $settingsCategories as $key => $value ) {
			$setting_category = $value;
			unset ( $setting_category ['settings'] );
			(new SettingCategory ())->fill ( $setting_category )->save ();
			if (isset ( $value ['settings'] ) && count ( $value ['settings'] ) > 0) {
				foreach ( $value ['settings'] as $setting ) {
					(new Setting ())->fill ( $setting )->save ();
				}
			}
		}
	}
}