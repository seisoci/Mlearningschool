<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Kelas;
use Faker\Generator as Faker;

$factory->define(Kelas::class, function (Faker $faker) {
    $name = $faker->sentence;
    return [
        'nama_kelas' => $name,
    ];
});
