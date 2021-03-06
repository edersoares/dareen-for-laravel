<?php

namespace Tests;

use Dareen\Definitions\SchemaDefinition;
use Exception;
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
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->connection = $connection = $this->getConnection();

        if ($this->withinTransaction ?? true) {
            $connection->beginTransaction();
        }
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

        if ($this->withinTransaction ?? true) {
            $this->connection->rollBack();
        }
    }

    /**
     * Set the definition migration for up method.
     *
     * @param Migration $definition
     *
     * @return void
     */
    public function runMigration(Migration $definition)
    {
        $this->definition = $definition;

        $definition->setConnection($this->connection);
        $definition->up();
    }

    /**
     * Run the schema definition test for abstract definition instance.
     *
     * @param AbstractDefinition $definition
     *
     * @throws Exception
     */
    public function runSchemaDefinitionTestFor(AbstractDefinition $definition)
    {
        $connection = $this->connection;

        $schema = new SchemaDefinition(
            $connection->getDoctrineSchemaManager()
        );

        $this->runMigration($definition);

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
