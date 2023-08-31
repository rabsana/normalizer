<?php
namespace Rabsana\Normalizer\Tests;

use Illuminate\Contracts\Auth\Authenticatable;

abstract class TestCase extends \Orchestra\Testbench\TestCase{
    protected $user;

    protected function getPackageProviders($app)
    {
        return [
            'Rabsana\Normalizer\ServiceProvider',
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Normalizer' => 'Rabsana\Normalizer',
        ];
    }

    /**
     * Setup the test environment.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->user = \Mockery::mock(Authenticatable::class);

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->withFactories(__DIR__.'/database/factories');
    }

    protected function loadMigrationsFrom($paths) {
        $paths = (is_array($paths)) ? $paths : [$paths];
        $this->app->afterResolving('migrator', function ($migrator) use ($paths) {
            foreach ((array) $paths as $path) {
                $migrator->path($path);
            }
        });
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('app.debug', true);
        $app['config']->set('app.key', 'AckfSECXIvnK5r28GVIWUAxmbBSjTsmF');

        $app['router']->get('login', ['as' => 'login', 'uses' => function () {
            return 'foo';
        }]);
    }

    protected function tearDown()
    {
        parent::tearDown();

        \Mockery::close();
    }
}
