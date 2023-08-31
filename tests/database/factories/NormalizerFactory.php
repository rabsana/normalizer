<?php
/**
 * Created by Rabsana Team <info.rabsana@gmail.com>
 * Website: https://rabsana.ir
 * Author: Sajjad Sisakhti <sajjad.30sakhti@gmail.com> <+989389785588>
 * Created At: 2020-04-30 04:24
 */

use Faker\Generator as Faker;

$factory->define(\Rabsana\Normalizer\Models\Normalizer::class, function (Faker $faker) {
    return [
        'from' => $faker->randomNumber(1),
        'to' => $faker->randomNumber(3),
        'ratio' => $faker->randomNumber(2),
        'active' => $faker->boolean,
        'prop' => $faker->text(10),
        'normalizable_id' => $faker->randomDigit,
        'normalizable_type' => $faker->text(20),
    ];
});
