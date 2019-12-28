<?php

namespace Tests\Signatures\Modifiers;

use Dareen\Signatures\Modifiers\NullableSignature;
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
