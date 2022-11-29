<?php

declare(strict_types=1);

namespace MichaelRubel\Nullify\Tests;

use ArrayAccess;
use PHPUnit\Framework\TestCase;

class NullifyArrayAccessTest extends TestCase
{
    public function testCanNullifyValuesInArrayAccessObjects()
    {
        $value = new ArrayAccessObject;
        $value['test'] = '';
        $result = new ArrayAccessObject;
        $result['test'] = null;
        $this->assertSame($result['test'], nullify($value)['test']);
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

        $this->assertEquals($result, nullify($value));
    }

    public function testCanObjectIsImmutableAfterUsingNullify()
    {
        $value = new ArrayAccessObject;
        $nested = new ArrayAccessObject;
        $nested['test'] = '';
        $value['obj'] = $nested;
        $this->assertSame('', $value['obj']['test']);

        nullify($value);

        $this->assertSame('', $value['obj']['test']);
    }
}

class ArrayAccessObject implements ArrayAccess
{
    public function offsetExists(mixed $offset)
    {
        return isset($this->{$offset});
    }

    public function offsetGet(mixed $offset)
    {
        return $this->{$offset};
    }

    public function offsetSet(mixed $offset, mixed $value)
    {
        $this->{$offset} = $value;
    }

    public function offsetUnset(mixed $offset)
    {
        unset($this->{$offset});
    }
}
