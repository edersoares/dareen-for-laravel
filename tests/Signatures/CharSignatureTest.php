<?php

namespace Tests\Signatures;

use Dareen\Signatures\CharSignature;
use Tests\TestCase;

class CharSignatureTest extends TestCase
{
    public function testInstance()
    {
        $signature = new CharSignature('char_column');

        $this->assertEquals('->char(\'char_column\')', (string) $signature);
        $this->assertEquals('->char(\'char_column\')', $signature->sign());
    }

    public function testInstanceWithLenght()
    {
        $signature = new CharSignature('char_column', 10);

        $this->assertEquals('->char(\'char_column\', 10)', (string) $signature);
        $this->assertEquals('->char(\'char_column\', 10)', $signature->sign());
    }
}
