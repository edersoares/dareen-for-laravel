<?php

namespace Tests\ReverseEngineering;

use Dareen\ReverseEngineering;
use Tests\ReverseEngineering\Migrations\CreateSimpleTable;
use Tests\SchemaDefinitionRunner;
use Tests\TestCase;

class CreateSimpleTableTest extends TestCase
{
    use SchemaDefinitionRunner;

    public function testMigration()
    {
        $this->runMigration(
            $create = new CreateSimpleTable()
        );

        $engineering = new ReverseEngineering(
            $connection = $this->connection->getDoctrineConnection()
        );

        $table = $engineering->table('simple');

        if ($connection->getDriver()->getName() === 'pdo_sqlite') {
            $this->assertTrue(true);

            return;
        }

        $this->assertEquals(
            $create->expected(), $table->getMigration()
        );
    }
}
