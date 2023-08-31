<?php
/**
 * Created by Rabsana Team <info.rabsana@gmail.com>
 * Website: https://rabsana.ir
 * Author: Sajjad Sisakhti <sajjad.30sakhti@gmail.com> <+989389785588>
 * Created At: 2020-04-30 04:24
 */

use Faker\Generator as Faker;

$factory->define(\Rabsana\Normalizer\Tests\Models\Foo::class, function (Faker $faker) {
    return [
        'price' => $faker->randomNumber(),
    ];
});
