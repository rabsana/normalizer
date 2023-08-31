<?php
namespace Rabsana\Normalizer;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Rabsana\Normalizer\Contracts\NormalizerRepository;
use Rabsana\Normalizer\Repositories\NormalizerRepositoryEloquent;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $policies = [
        'Rabsana\Normalizer\Models\Normalizer' => 'Rabsana\Normalizer\Policies\NormalizerPolicy',
    ];

    public function boot(){
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/admin.php');
        $this->loadViewsFrom(__DIR__.'/views', 'rabsana-normalizer');
        $this->loadTranslationsFrom(__DIR__.'/translations', 'rabsana-normalizer');

        $this->publishes([
            __DIR__.'/config/rabsana-normalizer.php' => config_path('rabsana-normalizer.php'),
        ]);

        Validator::extend('rabsana_normalizer_gt', function ($attribute, $value, $parameters, $validator) {
            return $value > request()->get($parameters[0]);
        });
        Validator::replacer('rabsana_normalizer_gt', function ($message, $attribute, $rule, $parameters) {
            return trans('rabsana-normalizer::validations.gt');
        });

        Validator::extend('rabsana_normalizer_exists', function ($attribute, $value, $parameters, $validator) {
            if(empty(request()->normalizable_type)){
                return false;
            }

            if(!in_array(request()->normalizable_type, array_keys(config('rabsana-normalizer.templates')))){
                return false;
            }

            return app(request()->normalizable_type)->where('id', $value)->exists();
        });
        Validator::replacer('rabsana_normalizer_exists', function ($message, $attribute, $rule, $parameters) {
            return trans('rabsana-normalizer::validations.exists');
        });

        $this->app->singleton('rabsana.normalizer', function($app){
            return new Normalizer();
        });

        $this->registerPolicies();
    }

    public function register(){
        $this->mergeConfigFrom(
          __DIR__.'/config/rabsana-normalizer.php',
          'rabsana-normalizer'
        );

        $this->app->bind(NormalizerRepository::class, NormalizerRepositoryEloquent::class);
    }

    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

}
