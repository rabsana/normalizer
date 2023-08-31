## Rabsana normalizer - rabsana/normalizer ##

**rabsana/normalizer** normalizes values, amounts, prices based on predefined list of ratios.

### Installation ###

Add following code to your project composer.json file(ensure token not expired):
```json

{
  "repositories": [
        {
          "type": "vcs",
          "url": "https://gitlab+deploy-token-totalexcoin:W3tDVLHJxg4uNtEsjtWi@repo.rabsana.ir/packages/normalizer.git"
        }
    ]
}
```

Install via [composer](http://getcomposer.org) in the root directory of a Laravel 5 application

    composer require rabsana/normalizer:dev-master

Add the following line to `config/app.php` inside the 'providers' array to use the service provider

	'Rabsana\Normalizer\ServiceProvider',

Update composer

	composer update

Run the package install command

	php artisan vendor:publish
	

### Usage ###

For accessing normalization features you only need to add  `NormalizerTrait` to your model:

```php
use Rabsana\Normalizer\Traits\NormalizerTrait;

class YourModelName extends Model{
    use NormalizerTrait;
}
```

This trait adds following methods to the model:
- **normalizers()** Which is a morphMany relationship to `Rabsana\Normalizer\Models\Normalizer::class` class.
- **normalize()** This method will normalize given column using value based on normalizing table.

### Overview ###

#### $normalizations
this property should be presents in models in order to normalizations can work.
```php
public static $normalizations = [
    'column' => 'representedName',
];
```

### Configs
After publishing configs there will be a `rabsana-normalizer.php` file in `config/` folder
```php
return [
    // These middlewares will be applied to all actions of controllers
    'middlewares' => [
        'web',
        'auth'
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
```

* You have to add middleware for restricting access to specific group of uses(e.g admins)
* You should specify master layout and main section of page. Also you should specify styles and scripts stacks
* Each class tha you want to be used in normalizations, you must add them in `templates` section.



### Tools ###

composer, phpunit, orchestra/testbench

### License ###

This packaged licensed to https://rabsana.ir
