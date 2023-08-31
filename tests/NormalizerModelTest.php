<?php
namespace Rabsana\Normalizer\Tests;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Rabsana\Normalizer\Models\Normalizer;

class NormalizerModelTest extends TestCase {
    protected $model = 'Rabsana\Normalizer\Models\Normalizer';

    public function test_class_exists(){
        $this->assertTrue(class_exists($this->model));
    }

    public function test_model_has_normalizable_method(){
        $this->assertTrue(method_exists($this->app->make($this->model), 'normalizable'), 'Method normalizable not exists!');
    }

    public function test_normalizable_method_returns_an_instance_of_MorphTo_class(){
        $instance = $this->app->make($this->model)->normalizable();

        $this->assertInstanceOf(MorphTo::class, $instance);
    }

    public function test_prop_dynamic_local_scope(){
        $this->assertInstanceOf(Builder::class, Normalizer::prop('foo'));
    }
    public function test_range_dynamic_local_scope(){
        $this->assertInstanceOf(Builder::class, Normalizer::range(1));
    }
    public function test_active_local_scope(){
        $this->assertInstanceOf(Builder::class, Normalizer::active());
    }

    public function test_table_name(){
        $this->assertEquals('rabsana_normalizer_normalizers', $this->app->make(Normalizer::class)->getTable());
    }
}
