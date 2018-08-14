<?php

namespace Tests;

use Dareen\SchemaDefinition;
use Illuminate\Database\Connection;
use Tests\Definitions\AbstractDefinition;

trait SchemaDefinitionRunner
{
    use ConnectionManager;

    /**
     * The connection with database.
     *
     * @var Connection
     */
    protected $connection;

    /**
     * The abstract definition instance to be used in tests.
     *
     * @var AbstractDefinition
     */
    protected $definition;

    /**
     * Configure the connection and transaction.
     *
     * @return void
     *
     * @throws \Exception
     */
    protected function setUp()
    {
        parent::setUp();

        $this->connection = $connection = $this->getConnection();

        $connection->beginTransaction();
    }

    /**
     * Run the down method and rollback.
     *
     * @return void
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->definition->down();
        $this->connection->rollBack();
    }

    /**
     * Run the schema definition test for abstract definition instance.
     *
     * @param AbstractDefinition $definition
     *
     * @throws \Exception
     */
    public function runSchemaDefinitionTestFor(AbstractDefinition $definition)
    {
        $this->definition = $definition;

        $connection = $this->connection;

        $schema = new SchemaDefinition(
            $connection->getDoctrineSchemaManager()
        );

        $definition->setConnection($connection);
        $definition->up();

        $tableDefinitionExpected = $definition->getDefinition(
            $connection->getDriverName()
        );

        $tableDefinitionCreated = $schema->getTableDefinition(
            $definition->getTableName()
        );

        $definitions = $tableDefinitionCreated->getDefinition();
        $total = count($tableDefinitionExpected);

        $this->assertCount($total, $definitions);

        foreach ($definitions as $definition) {
            $this->assertContains($definition, $tableDefinitionExpected);
        }
    }
}
