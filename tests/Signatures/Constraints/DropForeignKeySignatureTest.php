<?php

namespace Tests\Signatures\Constraints;

use Dareen\Signatures\Constraints\DropForeignKeySignature;
use Tests\TestCase;

class DropForeignKeySignatureTest extends TestCase
{
    public function testWithName()
    {
        $signature = new DropForeignKeySignature('posts_user_id_foreign');

        $this->assertEquals('->dropForeign(\'posts_user_id_foreign\')', (string) $signature);
        $this->assertEquals('->dropForeign(\'posts_user_id_foreign\')', $signature->sign());
    }

    public function testWithColumns()
    {
        $signature = new DropForeignKeySignature(['user_id', 'level_id']);

        $this->assertEquals('->dropForeign([\'user_id\', \'level_id\'])', (string) $signature);
        $this->assertEquals('->dropForeign([\'user_id\', \'level_id\'])', $signature->sign());
    }
}
