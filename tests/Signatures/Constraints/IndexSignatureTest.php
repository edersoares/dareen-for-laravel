<?php

namespace Tests\Signatures\Constraints;

use Dareen\Signatures\Constraints\IndexSignature;
use PHPUnit\Framework\TestCase;

class IndexSignatureTest extends TestCase
{
    public function testOneColumn()
    {
        $signature = new IndexSignature(['index_column']);

        $this->assertEquals('->index(\'index_column\')', (string) $signature);
        $this->assertEquals('->index(\'index_column\')', $signature->sign());
    }

    public function testTwoColumns()
    {
        $signature = new IndexSignature([
            'one_column', 'two_column'
        ]);

        $this->assertEquals('->index([\'one_column\', \'two_column\'])', (string) $signature);
        $this->assertEquals('->index([\'one_column\', \'two_column\'])', $signature->sign());
    }
}
