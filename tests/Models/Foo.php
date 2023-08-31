<?php
/**
 * Created by Rabsana Team <info.rabsana@gmail.com>
 * Website: https://rabsana.ir
 * Author: Sajjad Sisakhti <sajjad.30sakhti@gmail.com> <+989389785588>
 * Created At: 2020-04-30 04:10
 */

namespace Rabsana\Normalizer\Tests\Models;


use Illuminate\Database\Eloquent\Model;
use Rabsana\Normalizer\Traits\NormalizerTrait;

class Foo extends Model
{
    use NormalizerTrait;

    protected $table = 'rabsana_normalizer_foo';

    public static $normalizations = [
        'price' => 'price',
    ];
}
