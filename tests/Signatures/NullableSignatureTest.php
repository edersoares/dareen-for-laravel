<?php

namespace Tests\Signatures;

use Dareen\Signatures\NullableSignature;
use Tests\TestCase;

class NullableSignatureTest extends TestCase
{
    public function testInstance()
    {
        $signature = new NullableSignature();

        $this->assertEquals('->nullable()', (string) $signature);
        $this->assertEquals('->nullable()', $signature->sign());
    }
}
