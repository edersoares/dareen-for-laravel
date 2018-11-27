<?php

namespace Tests\Signatures;

use Dareen\Signatures\IncrementsSignature;
use Tests\TestCase;

class IncrementsSignatureTest extends TestCase
{
    public function testInstance()
    {
        $signature = new IncrementsSignature('id');

        $this->assertEquals('->increments(\'id\')', (string) $signature);
        $this->assertEquals('->increments(\'id\')', $signature->sign());
    }
}
