<?php
/**
 * Created by Rabsana Team <info.rabsana@gmail.com>
 * Website: https://rabsana.ir
 * Author: Sajjad Sisakhti <sajjad.30sakhti@gmail.com> <+989389785588>
 * Created At: 2020-04-29 05:21
 */
return [
    // These middlewares will be applied to all actions of controllers
    'middlewares' => [
        'web',
        'auth',
        'admin'
    ],

    'views' => [
        'master-layout' => 'rabsana-normalizer::layouts.master',
        'content-section' => 'content',
        'scripts-stack' => 'scripts',
        'styles-stack' => 'styles',
    ],

    // Represents classes that use NormalizerTrait
    'templates' => [
        [
            'class' => 'Rabsana\Normalizer\Tests\Models\Foo',
            'name' => 'localized name'
        ]
    ],
];
