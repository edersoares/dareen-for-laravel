<?php

namespace Tests\Signatures;

use Dareen\Signatures\OnUpdateSignature;
use Tests\TestCase;

class OnUpdateSignatureTest extends TestCase
{
    public function testSimpleSignature()
    {
        $signature = new OnUpdateSignature('cascade');

        $this->assertEquals('->onUpdate(\'cascade\')', (string) $signature);
        $this->assertEquals('->onUpdate(\'cascade\')', $signature->sign());
    }
}
