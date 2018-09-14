<?php

namespace Tests;

use Dareen\TableStatement;

class TableStatementTest extends TestCase
{
    /**
     * testOneSignature.
     *
     * @return void
     */
    public function testOneSignature()
    {
        $table = new TableStatement('->column()');

        $this->assertEquals('$table->column();', $table);
    }

    /**
     * testTwoSignature.
     *
     * @return void
     */
    public function testTwoSignature()
    {
        $table = new TableStatement('->one()', '->two()');

        $this->assertEquals('$table->one()->two();', $table);
    }
}
