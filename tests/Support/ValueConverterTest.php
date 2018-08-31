<?php

namespace Tests\Support;

use Dareen\Support\ValueConverter;
use PHPUnit\Framework\TestCase;

class ValueConverterTest extends TestCase
{
    public function testTrueConvert()
    {
        $converter = new class {
            use ValueConverter;
        };

        $converted = $converter->convertValue(true);

        $this->assertEquals('true', $converted);
    }

    public function testFalseConvert()
    {
        $converter = new class {
            use ValueConverter;
        };

        $converted = $converter->convertValue(false);

        $this->assertEquals('false', $converted);
    }

    public function testNullConvert()
    {
        $converter = new class {
            use ValueConverter;
        };

        $converted = $converter->convertValue(null);

        $this->assertEquals('null', $converted);
    }

    public function testZeroConvert()
    {
        $converter = new class {
            use ValueConverter;
        };

        $converted = $converter->convertValue(0);

        $this->assertEquals(0, $converted);
    }

    public function testOneConvert()
    {
        $converter = new class {
            use ValueConverter;
        };

        $converted = $converter->convertValue(1);

        $this->assertEquals(1, $converted);
    }

    public function testFloatConvert()
    {
        $converter = new class {
            use ValueConverter;
        };

        $converted = $converter->convertValue(123.456);

        $this->assertEquals(123.456, $converted);
    }

    public function testStringConvert()
    {
        $converter = new class {
            use ValueConverter;
        };

        $converted = $converter->convertValue('ValueConverter');

        $this->assertEquals('\'ValueConverter\'', $converted);
    }

    public function testArrayConvert()
    {
        $converter = new class {
            use ValueConverter;
        };

        $converted = $converter->convertValue([1, 23.45, 'Olá', null, false]);

        $this->assertEquals('[1, 23.45, \'Olá\', null, false]', $converted);
    }
}
