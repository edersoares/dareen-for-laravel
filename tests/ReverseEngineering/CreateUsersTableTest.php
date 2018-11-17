<?php

namespace Tests\ReverseEngineering;

use Dareen\ReverseEngineering;
use Tests\ReverseEngineering\Migrations\CreateSimpleTable;
use Tests\ReverseEngineering\Migrations\CreateUsersTable;
use Tests\SchemaDefinitionRunner;
use Tests\TestCase;

class CreateUsersTableTest extends TestCase
{
    use SchemaDefinitionRunner;

    public function testMigration()
    {
        $this->markTestSkipped();

        $this->runMigration(
            $create = new CreateUsersTable()
        );

        $engineering = new ReverseEngineering(
            $connection = $this->connection->getDoctrineConnection()
        );

        $table = $engineering->table('users');

        $this->assertEquals(
            $create->expected(), $table->getMigration()
        );
    }
}
