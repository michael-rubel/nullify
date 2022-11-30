<?php

namespace MichaelRubel\Nullify\Tests;

use MichaelRubel\Nullify\Nullify;
use PHPUnit\Framework\TestCase;

class NullifyTest extends TestCase
{
    public function testCanPassNull()
    {
        $value = null;
        $this->assertNull(Nullify::the($value));
    }

    public function testCanPassInt()
    {
        $value = 0;
        $this->assertSame(0, Nullify::the($value));
    }

    public function testCanPassString()
    {
        $value = '';
        $this->assertNull(Nullify::the($value));

        $value = 'test';
        $this->assertSame($value, Nullify::the($value));
    }

    public function testCanPassEmptyArray()
    {
        $value = [];
        $this->assertNull(Nullify::the($value));

        $value = ['test'];
        $this->assertSame($value, Nullify::the($value));
    }

    public function testCanPassObject()
    {
        $value = (object) ['test'];
        $this->assertSame($value, Nullify::the($value));
    }

    public function testCanPassEmptyObject()
    {
        $value = (object) [];
        $this->assertNull(Nullify::the($value));
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
        ], Nullify::the($value));
    }

    public function testLeavesNullAsNullInArray()
    {
        $value = [
            'test' => null,
        ];

        $this->assertSame($value, Nullify::the($value));
    }

    public function testLeavesIntAsIntInArray()
    {
        $value = [
            'test' => 0,
        ];

        $this->assertSame($value, Nullify::the($value));
    }

    public function testLeavesStringAsStringInArray()
    {
        $value = [
            'test' => 'test',
        ];

        $this->assertSame($value, Nullify::the($value));
    }

    public function testLeavesObjectAsObjectInArray()
    {
        $value = [
            'test' => (object) ['test'],
        ];

        $this->assertSame($value, Nullify::the($value));
    }
}
