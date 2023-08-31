<?php
namespace Rabsana\Normalizer\Tests;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Rabsana\Normalizer\Models\Normalizer;

class RoutesTest extends TestCase {
    public function test_index_route_exists()
    {
        $this->assertTrue(Route::has('rabsana_normalizer.normalizers.index'));
    }

    public function test_create_route_exists(){
        $this->assertTrue(Route::has('rabsana_normalizer.normalizers.create'));
    }

    public function test_post_route_exists(){
        $this->assertTrue(Route::has('rabsana_normalizer.normalizers.store'));
    }

    public function test_edit_route_exists(){
        $this->assertTrue(Route::has('rabsana_normalizer.normalizers.edit'));
    }

    public function test_update_route_exists(){
        $this->assertTrue(Route::has('rabsana_normalizer.normalizers.update'));
    }

    public function test_destroy_route_exists(){
        $this->assertTrue(Route::has('rabsana_normalizer.normalizers.destroy'));
    }
}
