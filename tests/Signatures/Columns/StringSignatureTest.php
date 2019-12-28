<?php

namespace Tests\Signatures\Columns;

use Dareen\Signatures\Columns\StringSignature;
use Tests\TestCase;

class StringSignatureTest extends TestCase
{
    public function testInstance()
    {
        $signature = new StringSignature('str_column');

        $this->assertEquals('->string(\'str_column\')', (string) $signature);
        $this->assertEquals('->string(\'str_column\')', $signature->sign());
    }

    public function testInstanceWithLenght()
    {
        $signature = new StringSignature('str_column', 10);

        $this->assertEquals('->string(\'str_column\', 10)', (string) $signature);
        $this->assertEquals('->string(\'str_column\', 10)', $signature->sign());
    }
}
