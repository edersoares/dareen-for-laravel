<?php

namespace Tests\Signatures;

use Dareen\Signatures\ColumnSignature;
use Tests\TestCase;

class ColumnSignatureTest extends TestCase
{
    public function testInstance()
    {
        $signature = new ColumnSignature('column', []);

        $this->assertEquals('->column()', (string) $signature);
        $this->assertEquals('->column()', $signature->sign());
    }

    public function testInstanceWithLenght()
    {
        $signature = new ColumnSignature('column', ['name']);

        $this->assertEquals('->column(\'name\')', (string) $signature);
        $this->assertEquals('->column(\'name\')', $signature->sign());
    }
}
