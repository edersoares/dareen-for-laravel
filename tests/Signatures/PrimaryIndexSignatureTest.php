<?php

namespace Tests\Signatures;

use Dareen\Signatures\PrimaryIndexSignature;
use PHPUnit\Framework\TestCase;

class PrimaryIndexSignatureTest extends TestCase
{
    public function testOneColumn()
    {
        $signature = new PrimaryIndexSignature(['primary_column']);

        $this->assertEquals('->primary(\'primary_column\')', (string) $signature);
        $this->assertEquals('->primary(\'primary_column\')', $signature->sign());
    }

    public function testTwoColumns()
    {
        $signature = new PrimaryIndexSignature([
            'one_column', 'two_column'
        ]);

        $this->assertEquals('->primary([\'one_column\', \'two_column\'])', (string) $signature);
        $this->assertEquals('->primary([\'one_column\', \'two_column\'])', $signature->sign());
    }
}
