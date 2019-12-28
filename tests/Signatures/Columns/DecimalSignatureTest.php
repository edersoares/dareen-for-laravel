<?php

namespace Tests\Signatures\Columns;

use Dareen\Signatures\Columns\DecimalSignature;
use Tests\TestCase;

class DecimalSignatureTest extends TestCase
{
    public function testInstance()
    {
        $signature = new DecimalSignature('decimal_column');

        $this->assertEquals('->decimal(\'decimal_column\')', (string) $signature);
        $this->assertEquals('->decimal(\'decimal_column\')', $signature->sign());
    }

    public function testInstanceWithPrecision()
    {
        $signature = new DecimalSignature('decimal_column', 10);

        $this->assertEquals('->decimal(\'decimal_column\', 10)', (string) $signature);
        $this->assertEquals('->decimal(\'decimal_column\', 10)', $signature->sign());
    }

    public function testInstanceWithPrecisionAndScale()
    {
        $signature = new DecimalSignature('decimal_column', 10, 4);

        $this->assertEquals('->decimal(\'decimal_column\', 10, 4)', (string) $signature);
        $this->assertEquals('->decimal(\'decimal_column\', 10, 4)', $signature->sign());
    }
}
