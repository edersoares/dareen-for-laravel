<?php

namespace Tests;

use Dareen\ReverseEngineering;
use Dareen\TableReverseEngineering;
use Doctrine\DBAL\Connection;
use Tests\Definitions\TableWithCommonColumns;

class ReverseEngineeringTest extends TestCase
{
    use SchemaDefinitionRunner;

    public function testTableMethod()
    {
        /** @var Connection $connection */
        $reverse = new ReverseEngineering(
            $this->getConnection()->getDoctrineConnection()
        );

        $this->runMigration(
            new TableWithCommonColumns()
        );

        $table = $reverse->table('common');

        $this->assertInstanceOf(TableReverseEngineering::class, $table);
    }
}
