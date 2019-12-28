<?php

namespace Tests\Signatures\Modifiers;

use Dareen\Signatures\Modifiers\CommentSignature;
use Tests\TestCase;

class CommentSignatureTest extends TestCase
{
    public function testInstance()
    {
        $signature = new CommentSignature('Some comment');

        $this->assertEquals('->comment(\'Some comment\')', (string) $signature);
        $this->assertEquals('->comment(\'Some comment\')', $signature->sign());
    }
}
