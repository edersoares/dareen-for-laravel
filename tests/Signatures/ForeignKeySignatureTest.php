<?php

namespace Tests\Signatures;

use Dareen\Signatures\ForeignKeySignature;
use Tests\TestCase;

class ForeignKeySignatureTest extends TestCase
{
    public function testSimpleSignature()
    {
        $signature = new ForeignKeySignature(['user_id'], ['id'], 'users');

        $this->assertEquals('->foreign(\'user_id\')->references(\'id\')->on(\'users\')', (string) $signature);
        $this->assertEquals('->foreign(\'user_id\')->references(\'id\')->on(\'users\')', $signature->sign());
    }

    public function testMultipleColumnsSignature()
    {
        $signature = new ForeignKeySignature(['user_id', 'level_id'], ['user_id', 'level_id'], 'users_level');

        $this->assertEquals('->foreign([\'user_id\', \'level_id\'])->references([\'user_id\', \'level_id\'])->on(\'users_level\')', (string) $signature);
        $this->assertEquals('->foreign([\'user_id\', \'level_id\'])->references([\'user_id\', \'level_id\'])->on(\'users_level\')', $signature->sign());
    }
}
