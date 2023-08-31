<?php
/**
 * Created by Rabsana Team <info.rabsana@gmail.com>
 * Website: https://rabsana.ir
 * Author: Sajjad Sisakhti <sajjad.30sakhti@gmail.com> <+989389785588>
 * Created At: 2020-06-10 19:32
 */

namespace Rabsana\Normalizer\Policies;

use App\Policies\Policy;
use Illuminate\Auth\Access\HandlesAuthorization;

class NormalizerPolicy extends Policy
{
    use HandlesAuthorization;

    public function abilities()
    {
        return [
            'index' => trans('rabsana-normalizer::messages.normalizer'),
        ];
    }
}
