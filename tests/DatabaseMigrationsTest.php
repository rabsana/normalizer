<?php
namespace Rabsana\Normalizer\Tests;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Schema;
use Rabsana\Normalizer\Models\Normalizer;

class DatabaseMigrationsTest extends TestCase {
    protected function setUp()
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'testing']);
    }


    public function test_table_structure(){
        $this->assertEquals([
            'id',
            'active',
            'from',
            'to',
            'prop',
            'normalizable_id',
            'normalizable_type',
            'ratio',
            'created_at',
            'updated_at',
        ],Schema::getColumnListing('rabsana_normalizer_normalizers'));
    }


}
