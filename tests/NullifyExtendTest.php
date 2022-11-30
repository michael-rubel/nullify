<?php

namespace MichaelRubel\Nullify\Tests;

use MichaelRubel\Nullify\Nullify;
use PHPUnit\Framework\TestCase;

class NullifyExtendTest extends TestCase
{
    public function testExtendNullify()
    {
        new NewNullify;

        $this->assertTrue(true);
    }
}

class NewNullify extends Nullify
{
    public function __construct()
    {
        static::nullify('');
        static::blank('');
        static::clone('');
    }
}
