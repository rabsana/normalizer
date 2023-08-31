<?php
namespace Rabsana\Normalizer\Tests;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Rabsana\Normalizer\Models\Normalizer;

class ViewsTest extends TestCase {
    public function test_index_view_exists()
    {
        $this->assertTrue(View::exists('rabsana-normalizer::index'));
    }

    public function test_create_view_exists()
    {
        $this->assertTrue(View::exists('rabsana-normalizer::create'));
    }

    public function test_edit_view_exists()
    {
        $this->assertTrue(View::exists('rabsana-normalizer::edit'));
    }

    public function test_master_layout_exists()
    {
        $this->assertTrue(View::exists('rabsana-normalizer::layouts.master'));
    }
}
