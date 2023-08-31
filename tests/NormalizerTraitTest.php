<?php
namespace Rabsana\Normalizer\Tests;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Rabsana\Normalizer\Models\Normalizer;

class NormalizerTraitTest extends TestCase {
    protected $trait = 'Rabsana\Normalizer\Traits\NormalizerTrait';

    public function test_trait_exists(){
        $this->assertTrue(trait_exists($this->trait), 'NormalizerTrait trait not found');
    }

    public function test_polymorphic_method_exists()
    {
        $this->assertTrue(method_exists($this->trait, 'normalizers'));
    }

    public function test_normalizers_method_return_MorphMany_object(){
        $mock = $this->getMockBuilder($this->trait)
            ->setMethods(['morphMany'])
            ->getMockForTrait();

        $morphMany = \Mockery::mock(MorphMany::class);

        $mock->expects($this->any())->method('morphMany')->withAnyParameters()->willReturn($morphMany);

        $this->assertEquals($morphMany, $mock->normalizers());
    }

    public function test_normalize_using_table_method(){
        $mock = $this->getMockBuilder($this->trait)
            ->setMethods(['calculate', 'propertyRegisteredAsNormalization'])
            ->getMockForTrait();

        $mock->expects($this->once())->method('calculate')->willReturn(101);

        $mock->expects($this->once())->method('propertyRegisteredAsNormalization')->willReturn(true);

        $this->assertEquals(101, $mock->normalize('foo', 100));

    }

    public function test_normalize_to_default_method(){
        $mock = $this->getMockBuilder($this->trait)
            ->setMethods(['calculate', 'propertyRegisteredAsNormalization'])
            ->getMockForTrait();

        $mock->expects($this->never())->method('calculate')->willReturn(101);

        $mock->expects($this->once())->method('propertyRegisteredAsNormalization')->willReturn(false);

        $this->assertEquals(100, $mock->normalize('foo', 100));

    }

    public function test_method_propertyRegisteredAsNormalization()
    {
            $mock = $this->getMockBuilder($this->trait)
                ->setMethods(['getNormalizations'])
                ->getMockForTrait();

            $mock->expects($this->exactly(2))->method('getNormalizations')->willReturn([
                'foo' => 'bar',
            ]);

            $this->assertEquals(true, $mock->propertyRegisteredAsNormalization('foo'));

            $this->assertEquals(false, $mock->propertyRegisteredAsNormalization('baz'));
    }

    public function test_getNormalizations_method()
    {
        $mock = $this->getMockBuilder($this->trait)
            ->getMockForTrait();

        $this->assertEquals([], $mock->getNormalizations());
    }

    /*public function test_calculate_method()
    {
        $mock = $this->getMockBuilder($this->trait)
            ->setMethods(['filterRecords'])
            ->getMockForTrait();

        $mockModel = \Mockery::mock(Normalizer::class);
        $mockModel->shouldReceive('getAttribute')->once()->with('ratio')->andReturn(1.1);

        $mock->expects($this->once())->method('filterRecords')->willReturn($mockModel);

        $reflectionMethod = new \ReflectionMethod(get_class($mock), 'calculate');
        $reflectionMethod->setAccessible(true);

        $this->assertEquals(20 * 1.1, $reflectionMethod->invokeArgs($mock, ['foo', 100]));

    }

    public function test_calculate_method_empty_normalizers()
    {
        $mock = $this->getMockBuilder($this->trait)
            ->setMethods(['filterRecords'])
            ->getMockForTrait();

        $mock->expects($this->once())->method('filterRecords')->willReturn(null);

        $reflectionMethod = new \ReflectionMethod(get_class($mock), 'calculate');
        $reflectionMethod->setAccessible(true);

        $this->assertEquals(100, $reflectionMethod->invokeArgs($mock, ['foo', 100]));

    }*/


}
