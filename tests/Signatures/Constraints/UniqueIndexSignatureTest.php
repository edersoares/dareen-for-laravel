<?php

namespace Tests\Signatures\Constraints;

use Dareen\Signatures\Constraints\UniqueIndexSignature;
use PHPUnit\Framework\TestCase;

class UniqueIndexSignatureTest extends TestCase
{
    public function testOneColumn()
    {
        $signature = new UniqueIndexSignature(['unique_column']);

        $this->assertEquals('->unique(\'unique_column\')', (string) $signature);
        $this->assertEquals('->unique(\'unique_column\')', $signature->sign());
    }

    public function testTwoColumns()
    {
        $signature = new UniqueIndexSignature([
            'one_column', 'two_column'
        ]);

        $this->assertEquals('->unique([\'one_column\', \'two_column\'])', (string) $signature);
        $this->assertEquals('->unique([\'one_column\', \'two_column\'])', $signature->sign());
    }
}
