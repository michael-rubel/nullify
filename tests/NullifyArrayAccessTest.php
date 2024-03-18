<?php

declare(strict_types=1);

namespace MichaelRubel\Nullify\Tests;

use ArrayAccess;
use MichaelRubel\Nullify\Nullify;
use PHPUnit\Framework\TestCase;

class NullifyArrayAccessTest extends TestCase
{
    public function testCanNullifyValuesInArrayAccessObjects()
    {
        $value = new ArrayAccessObject;
        $value['test'] = '';
        $result = new ArrayAccessObject;
        $result['test'] = null;
        $this->assertSame($result['test'], Nullify::the($value)['test']);
    }

    public function testCanNullifyValuesInNestedArrayAccess()
    {
        $value = new ArrayAccessObject;
        $nested = new ArrayAccessObject;
        $nested['test'] = '';
        $value['obj'] = $nested;
        $this->assertSame('', $value['obj']['test']);

        $result = new ArrayAccessObject;
        $nested = new ArrayAccessObject;
        $nested['test'] = null;
        $result['obj'] = $nested;
        $this->assertSame(null, $result['obj']['test']);

        $this->assertEquals($result, Nullify::the($value));
    }

    public function testObjectIsImmutableAfterUsingNullify()
    {
        $value = new ArrayAccessObject;
        $nested = new ArrayAccessObject;
        $nested['test'] = '';
        $value['obj'] = $nested;
        $this->assertSame('', $value['obj']['test']);

        $nullified = Nullify::the($value);
        $this->assertEquals($nested,  $nullified['obj']);
        $this->assertSame(null, $nullified['obj']['test']);
        $this->assertSame('', $value['obj']['test']);
    }

    public function testArrayIsImmutableAfterUsingNullify()
    {
        $value = [];
        $nested = [];
        $nested['test'] = '';
        $value['obj'] = $nested;
        $this->assertSame('', $value['obj']['test']);

        $nullified = Nullify::the($value);
        $this->assertEquals($nested,  $nullified['obj']);
        $this->assertSame(null, $nullified['obj']['test']);
        $this->assertSame('', $value['obj']['test']);
    }
}

class ArrayAccessObject implements ArrayAccess
{
    public object $obj;
    public ?string $test;

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->{$offset});
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->{$offset};
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->{$offset} = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->{$offset});
    }
}
