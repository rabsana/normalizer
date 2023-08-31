<?php
namespace Rabsana\Normalizer\Tests;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\DB;
use Rabsana\Normalizer\Models\Normalizer;
use Rabsana\Normalizer\Tests\Models\Foo;

class SystemTest extends TestCase {
    protected function setUp()
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'testing']);
    }

    public function test_storing_new_record(){
        $data = $this->get_testing_data();

        factory(Foo::class)->create([
            'price' => 10
        ]);

        $response = $this->actingAs($this->user)->post(route('rabsana_normalizer.normalizers.store'), $data);

        $response->assertStatus(201);

        $response->assertJson([
            'record' => [
                'id' => 1
            ],
        ]);

        $this->assertEquals(1, DB::table('rabsana_normalizer_normalizers')->count());

        $foo = Foo::first();

        $this->assertEquals(11, $foo->normalize('price', 5));
    }

    public function test_update_action_works()
    {
        $data = $this->get_testing_data();

        $foo = factory(Foo::class)->create([
            'price' => 200
        ]);

        $normalizer = factory(Normalizer::class)->create($data);

        $newData = [
            'ratio' => 1.9,
            'normalizable_id' => $foo->id,
            'normalizable_type' => get_class($foo),
            'from' => 50,
            'to' => 500,
        ];


        $response = $this->actingAs($this->user)->put(route('rabsana_normalizer.normalizers.update', $normalizer->id), $newData);

        $response->assertStatus(204);

        $this->assertEmpty($response->content(), 'The response content should be empty');

        $normalizer->refresh();

        $this->assertEquals($foo->price * 1.9, $foo->normalize('price', 180));
    }

    public function test_delete_existing_record(){
        $data = $this->get_testing_data();

        $normalizer = factory(Normalizer::class)->create($data);

        $response = $this->actingAs($this->user)->delete(route('rabsana_normalizer.normalizers.destroy', $normalizer->id));

        $response->assertStatus(204);

        $this->assertEmpty($response->content(), 'The response content should be empty');

        $this->assertEquals(0, DB::table('rabsana_normalizer_normalizers')->count());
    }

    protected function get_testing_data(){
        return [
            'normalizable_id' => 1,
            'normalizable_type' => 'Rabsana\Normalizer\Tests\Models\Foo',
            'from' => 0,
            'to' => 10,
            'ratio' => 1.1,
            'active' => 1,
            'prop' => 'price',

        ];
    }
}
