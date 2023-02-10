<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {     
    	$this->call(AdminUsersTableSeeder::class);
    	$this->call(UserRolesTableSeeder::class);
        $this->call(EmailTemplatesTableSeeder::class);
        $this->call(SettingCategoryTableSeeder::class);
        $this->call(PaymentTypeSeeder::class);
        $this->call(CurrenciesSeeder::class);
        $this->call(BranchSeeder::class);
        $this->call(PaymentCategorySeeder::class);
        $this->call(CollectorSeeder::class);
    }
}
