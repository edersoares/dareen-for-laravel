<?php

namespace Tests\Signatures\Modifiers;

use Dareen\Signatures\Modifiers\OnUpdateSignature;
use Tests\TestCase;

class OnUpdateSignatureTest extends TestCase
{
    public function testSimpleSignature()
    {
        $signature = new OnUpdateSignature('CASCADE');

        $this->assertEquals('->onUpdate(\'cascade\')', (string) $signature);
        $this->assertEquals('->onUpdate(\'cascade\')', $signature->sign());
    }
}
