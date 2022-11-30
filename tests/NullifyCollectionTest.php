<?php

declare(strict_types=1);

namespace MichaelRubel\Nullify\Tests;

use Illuminate\Support\Collection;
use MichaelRubel\Nullify\Nullify;
use PHPUnit\Framework\TestCase;

class NullifyCollectionTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Collection::macro('nullify', function () {
            return Nullify::the(values: $this);
        });
    }

    public function testCanNullifyEmptyCollection(): void
    {
        $this->assertNull((new Collection)->nullify());
    }

    public function testCanNullifyValuesInCollection(): void
    {
        $result = Collection::make([
            'null'               => null,
            'empty'              => '',
            'space'              => ' ',
            'space_with_content' => ' test ',
            'array'              => [],
            'collection'         => collect(),
            'countable'          => new \SplObjectStorage,
            'correct_one'        => 'Correct one!',
        ])->nullify()->toArray();

        $this->assertSame([
            'null'               => null,
            'empty'              => null,
            'space'              => null,
            'space_with_content' => ' test ',
            'array'              => null,
            'collection'         => null,
            'countable'          => null,
            'correct_one'        => 'Correct one!',
        ], $result);
    }

    public function testCanNullifyValuesWithNestedArrayAccess(): void
    {
        $result = Collection::make([
            'test'       => new \SplObjectStorage,
            'first_name' => collect(['first_part' => false, 'last_part' => '']),
            'last_name'  => collect(['first_part' => true, 'last_part' => []]),
            'full_name'  => collect(['first_part' => new \SplObjectStorage, 'last_part' => collect(['additional_part' => ['next_part' => ['deep_part' => '']]])]),
        ])->nullify()->toArray();

        $this->assertSame([
            'test'       => null,
            'first_name' => ['first_part' => false, 'last_part' => null],
            'last_name'  => ['first_part' => true, 'last_part' => null],
            'full_name'  => ['first_part' => null, 'last_part' => ['additional_part' => ['next_part' => ['deep_part' => null]]]],
        ], $result);
    }

    /** @test */
    public function testCanNullifyValuesWithoutConvertingToArray(): void
    {
        $nullified = Collection::make([
            'first_name' => ['first_part' => false, 'last_part'  => ''],
            'last_name'  => collect(['first_part' => false, 'last_part'  => []]),
            'full_name'  => ['first_part' => true, 'last_part'  => collect(['additional_part' => ''])],
        ])->nullify();

        $expected = Collection::make([
            'first_name' => ['first_part' => false, 'last_part'  => null],
            'last_name'  => collect(['first_part' => false, 'last_part'  => null]),
            'full_name'  => ['first_part' => true, 'last_part'  => collect(['additional_part' => null])],
        ]);

        $this->assertEquals($expected, $nullified);
    }

    /** @test */
    public function testArrayIteratorBehavesAsExpectedWhenNullify(): void
    {
        $nullified = Collection::make(['iterator' => new \ArrayIterator([1, 2, 3])])->nullify();
        $expected  = Collection::make(['iterator' => new \ArrayIterator([1, 2, 3])]);
        $this->assertEquals($expected, $nullified);

        $nullified = Collection::make(['iterator' => new \ArrayIterator])->nullify();
        $expected  = Collection::make(['iterator' => null]);
        $this->assertEquals($expected, $nullified);
    }
}