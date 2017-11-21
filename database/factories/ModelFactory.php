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

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'department' => 'marketing',
        'remember_token' => str_random(10),
        'verified' => $verificado = $faker->randomElement([User::USUARIO_VERIFICADO, USER::USUARIO_NO_VERIFICADO]),
        'verification_token' => $verificado == User::USUARIO_VERIFICADO ? null : User::generateVerificationToken(),
        'admin' => $faker->randomElement([User::USUARIO_ADMIN, User::USUARIO_REGULAR]),
    ];
});

$factory->define(App\Department::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->word,
        //'department' => $faker -> department,
        //'description' => $faker->paragraph(1),

    ];
});
/**$factory->define(App\Worker::class, function (Faker\Generator $faker) {
 *
 * return [
 * 'description' => $faker->paragraph(1),
 * ];
 * });*/