<?php

namespace Tests\Signatures;

use Dareen\Signatures\Signature;
use Tests\TestCase;

class SignatureTest extends TestCase
{
    public function testInteger()
    {
        $signature = new Signature('integer', ['integer_column']);

        $this->assertEquals('->integer(\'integer_column\')', (string) $signature);
        $this->assertEquals('->integer(\'integer_column\')', $signature->sign());
    }

    public function testIntegerAutoincrement()
    {
        $signature = new Signature('integer', ['integer_column', true]);

        $this->assertEquals('->integer(\'integer_column\', true)', (string) $signature);
        $this->assertEquals('->integer(\'integer_column\', true)', $signature->sign());
    }
}
