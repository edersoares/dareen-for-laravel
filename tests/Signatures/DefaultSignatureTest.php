<?php

namespace Tests\Signatures;

use Dareen\Signatures\DefaultSignature;
use Tests\TestCase;

class DefaultSignatureTest extends TestCase
{
    public function testDefaultBooleanTrue()
    {
        $signature = new DefaultSignature(true);

        $this->assertEquals('->default(true)', (string) $signature);
        $this->assertEquals('->default(true)', $signature->sign());
    }

    public function testDefaultBooleanFalse()
    {
        $signature = new DefaultSignature(false);

        $this->assertEquals('->default(false)', (string) $signature);
        $this->assertEquals('->default(false)', $signature->sign());
    }

    public function testDefaultBooleanNull()
    {
        $signature = new DefaultSignature(null);

        $this->assertEquals('->default(null)', (string) $signature);
        $this->assertEquals('->default(null)', $signature->sign());
    }

    public function testDefaultZero()
    {
        $signature = new DefaultSignature(0);

        $this->assertEquals('->default(0)', (string) $signature);
        $this->assertEquals('->default(0)', $signature->sign());
    }

    public function testDefaultOne()
    {
        $signature = new DefaultSignature(1);

        $this->assertEquals('->default(1)', (string) $signature);
        $this->assertEquals('->default(1)', $signature->sign());
    }

    public function testDefaultFloat()
    {
        $signature = new DefaultSignature(1234.56);

        $this->assertEquals('->default(1234.56)', (string) $signature);
        $this->assertEquals('->default(1234.56)', $signature->sign());
    }

    public function testDefaultString()
    {
        $signature = new DefaultSignature('Some value');

        $this->assertEquals('->default(\'Some value\')', (string) $signature);
        $this->assertEquals('->default(\'Some value\')', $signature->sign());
    }
}
