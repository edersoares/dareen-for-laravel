<?php

namespace Tests\Signatures;

use Dareen\Signatures\OnDeleteSignature;
use Tests\TestCase;

class OnDeleteSignatureTest extends TestCase
{
    public function testSimpleSignature()
    {
        $signature = new OnDeleteSignature('cascade');

        $this->assertEquals('->onDelete(\'cascade\')', (string) $signature);
        $this->assertEquals('->onDelete(\'cascade\')', $signature->sign());
    }
}
