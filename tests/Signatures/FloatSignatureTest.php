<?php

namespace Tests\Signatures;

use Dareen\Signatures\FloatSignature;
use Tests\TestCase;

class FloatSignatureTest extends TestCase
{
    public function testInstance()
    {
        $signature = new FloatSignature('float_column');

        $this->assertEquals('->float(\'float_column\')', (string) $signature);
        $this->assertEquals('->float(\'float_column\')', $signature->sign());
    }

    public function testInstanceWithPrecision()
    {
        $signature = new FloatSignature('float_column', 10);

        $this->assertEquals('->float(\'float_column\', 10)', (string) $signature);
        $this->assertEquals('->float(\'float_column\', 10)', $signature->sign());
    }

    public function testInstanceWithPrecisionAndLength()
    {
        $signature = new FloatSignature('float_column', 10, 4);

        $this->assertEquals('->float(\'float_column\', 10, 4)', (string) $signature);
        $this->assertEquals('->float(\'float_column\', 10, 4)', $signature->sign());
    }
}
