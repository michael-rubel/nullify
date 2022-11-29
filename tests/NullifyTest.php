<?php

namespace MichaelRubel\Nullify\Tests;

use PHPUnit\Framework\TestCase;

class NullifyTest extends TestCase
{
    public function testCanPassNull()
    {
        $value = null;
        $this->assertNull(nullify($value));
    }

    public function testCanPassInt()
    {
        $value = 0;
        $this->assertSame(0, nullify($value));
    }

    public function testCanPassString()
    {
        $value = '';
        $this->assertNull(nullify($value));

        $value = 'test';
        $this->assertSame($value, nullify($value));
    }

    public function testCanPassEmptyArray()
    {
        $value = [];
        $this->assertNull(nullify($value));

        $value = ['test'];
        $this->assertSame($value, nullify($value));
    }

    public function testCanPassObject()
    {
        $value = (object) ['test'];
        $this->assertSame($value, nullify($value));
    }

    public function testCanPassEmptyObject()
    {
        $value = (object) [];
        $this->assertNull(nullify($value));
    }

    public function testNullifiesNestedArrays()
    {
        $value = [
            'one' => [
                'one_and_half' => [],
                'two' => ['three' => ['four' => '']]
            ]
        ];

        $this->assertSame([
            'one' => [
                'one_and_half' => null,
                'two' => ['three' => ['four' => null]]
            ]
        ], nullify($value));
    }

    public function testLeavesNullAsNullInArray()
    {
        $value = [
            'test' => null,
        ];

        $this->assertSame($value, nullify($value));
    }

    public function testLeavesIntAsIntInArray()
    {
        $value = [
            'test' => 0,
        ];

        $this->assertSame($value, nullify($value));
    }

    public function testLeavesStringAsStringInArray()
    {
        $value = [
            'test' => 'test',
        ];

        $this->assertSame($value, nullify($value));
    }

    public function testLeavesObjectAsObjectInArray()
    {
        $value = [
            'test' => (object) ['test'],
        ];

        $this->assertSame($value, nullify($value));
    }
}
