<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(Admin\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' =>  Hash::make ("admin123"),
        'gender'=> $faker->randomElement($array = array ('Male','Female')),
        'mobile_number'=>9791005608,
        'access_token'=>bcrypt('12334'),
        'user_role_id'=>$faker->randomElement($array = array (1,2,3)),
        'is_verified'=>1,
        'is_active'=>$faker->randomElement($array = array (1,0)),
        'creator_id'=>'1',
        'updator_id'=>'1'
    ];
});

