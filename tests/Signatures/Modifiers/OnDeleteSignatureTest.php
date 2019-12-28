<?php

namespace Tests\Signatures\Modifiers;

use Dareen\Signatures\Modifiers\OnDeleteSignature;
use Tests\TestCase;

class OnDeleteSignatureTest extends TestCase
{
    public function testSimpleSignature()
    {
        $signature = new OnDeleteSignature('CASCADE');

        $this->assertEquals('->onDelete(\'cascade\')', (string) $signature);
        $this->assertEquals('->onDelete(\'cascade\')', $signature->sign());
    }
}
