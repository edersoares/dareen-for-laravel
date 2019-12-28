<?php

namespace Tests\Signatures\Columns;

use Dareen\Signatures\Columns\RememberTokenSignature;
use Tests\TestCase;

class RememberTokenSignatureTest extends TestCase
{
    public function testInstance()
    {
        $signature = new RememberTokenSignature();

        $this->assertEquals('->rememberToken()', (string) $signature);
        $this->assertEquals('->rememberToken()', $signature->sign());
    }
}
