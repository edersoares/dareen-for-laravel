<?php

namespace Tests;

use Dareen\ReverseEngineering;
use Dareen\TableReverseEngineering;
use Doctrine\DBAL\Connection;
use Exception;
use Tests\Definitions\Tables\TableWithCommonColumns;

class ReverseEngineeringTest extends TestCase
{
    use SchemaDefinitionRunner;

    /**
     * Configure the connection and transaction.
     *
     * @return void
     *
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->connection = $connection = $this->getConnection();
    }

    /**
     * Run the down method and rollback.
     *
     * @return void
     *
     * @throws Exception
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->definition->down();
    }

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
