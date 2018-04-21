<?php

use Faker\Generator as Faker;
use Carbon\Carbon; //使用Carbon时间类

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {

    static $password;
    //创建时间戳
    $now = Carbon::now()->toDateTimeString();

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        //判断是否有密码，没有就默认123456
        'password' => $password ?: $password = bcrypt(123456),
        'remember_token' => str_random(10),
        //随机生成小段落文本
        'introduction' => $faker->sentence(),
        'created_at' => $now,
        'updated_at' => $now,
    ];
});
