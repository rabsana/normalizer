<?php
namespace Rabsana\Normalizer\Tests;


use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Rabsana\Normalizer\Contracts\NormalizerRepository;
use Rabsana\Normalizer\Controllers\NormalizerController;
use Rabsana\Normalizer\Models\Normalizer;
use Rabsana\Normalizer\Repositories\NormalizerRepositoryEloquent;

class NormalizerControllerTest extends TestCase {
    protected $controller = 'Rabsana\Normalizer\Controllers\NormalizerController';

    public function test_controller_exists()
    {
        $this->assertTrue(class_exists($this->controller));
    }

    public function test_index_action_exists(){
        $this->assertTrue(method_exists($this->app->make($this->controller), 'index'));
    }

    public function test_create_action_exists(){
        $this->assertTrue(method_exists($this->app->make($this->controller), 'create'));
    }

    public function test_store_action_exists(){
        $this->assertTrue(method_exists($this->app->make($this->controller), 'store'));
    }

    public function test_edit_action_exists(){
        $this->assertTrue(method_exists($this->app->make($this->controller), 'edit'));
    }

    public function test_update_action_exists(){
        $this->assertTrue(method_exists($this->app->make($this->controller), 'update'));
    }

    public function test_destroy_action_exists(){
        $this->assertTrue(method_exists($this->app->make($this->controller), 'destroy'));
    }

    public function test_index_action_returns_proper_view()
    {
        $mock = \Mockery::mock(NormalizerRepository::class);
        $mock->shouldReceive('all')->once()->andReturn('foo');

        $this->app->instance(NormalizerRepository::class, $mock);



        $this->assertEquals(view('rabsana-normalizer::index')->getName(), $this->app->make($this->controller)->index()->getName());
    }

    public function test_create_action_returns_proper_view()
    {
        $this->assertEquals(view('rabsana-normalizer::create')->getName(), $this->app->make($this->controller)->create()->getName());
    }

    public function test_edit_action_returns_proper_view()
    {
        $mock = \Mockery::mock(NormalizerRepository::class);
        $mock->shouldReceive('find')->with(1)->once()->andReturn('foo');
        $mock->shouldReceive('templates')->once()->andReturn('bar');

        $this->app->instance(NormalizerRepository::class, $mock);

        $this->assertEquals(view('rabsana-normalizer::edit')->getName(), $this->app->make($this->controller)->edit(1)->getName());
    }

    public function test_only_logged_in_user_can_access_index_action(){
        $this->assertTrue(Route::has('login'), 'The route \'login\' should be defined');

        $mock = \Mockery::mock(NormalizerRepository::class);
        $mock->shouldReceive('all')->once()->andReturn('foo');

        $this->app->instance(NormalizerRepository::class, $mock);

        $response = $this->get(route('rabsana_normalizer.normalizers.index'));

        $response->assertStatus(302);

        $response->assertRedirect(route('login'));

        $mockedUser = \Mockery::mock('Illuminate\Contracts\Auth\Authenticatable');

        $response = $this->actingAs($mockedUser)->get(route('rabsana_normalizer.normalizers.index'));

        $response->assertStatus(200);

    }

    public function test_index_action_pass_desired_variable_to_view(){
        $mock = \Mockery::mock(NormalizerRepository::class);
        $mock->shouldReceive('all')->once()->andReturn('foo');

        $this->app->instance(NormalizerRepository::class, $mock);

        $response = $this->actingAs($this->user)->get(route('rabsana_normalizer.normalizers.index'));

        $response->assertStatus(200);

        $response->assertViewIs('rabsana-normalizer::index');

        $response->assertViewHas('normalizers', 'foo');

    }

    public function test_create_action_pass_desired_variable_to_view(){
        $mock = \Mockery::mock(NormalizerRepository::class);
        $mock->shouldReceive('templates')->once()->andReturn('foo');

        $this->app->instance(NormalizerRepository::class, $mock);

        $response = $this->actingAs($this->user)->get(route('rabsana_normalizer.normalizers.create'));

        $response->assertStatus(200);

        $response->assertViewIs('rabsana-normalizer::create');

        $response->assertViewHas('templates', 'foo');

    }

    public function test_edit_action_pass_desired_variable_to_view(){
        $mock = \Mockery::mock(NormalizerRepository::class);
        $mock->shouldReceive('find')->with(1)->once()->andReturn('foo');
        $mock->shouldReceive('templates')->once()->andReturn('bar');

        $this->app->instance(NormalizerRepository::class, $mock);

        $response = $this->actingAs($this->user)->get(route('rabsana_normalizer.normalizers.edit', 1));

        $response->assertStatus(200);

        $response->assertViewIs('rabsana-normalizer::edit');

        $response->assertViewHas('normalizer', 'foo');
        $response->assertViewHas('templates', 'bar');
    }
}
