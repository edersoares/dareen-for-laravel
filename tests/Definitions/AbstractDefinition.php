<?php

namespace Tests\Definitions;

use Illuminate\Database\Connection;

abstract class AbstractDefinition
{
    /**
     * Schema builder for migration.
     *
     * @var \Illuminate\Database\Schema\Builder
     */
    protected $builder;

    /**
     * Schema manager for manipulate the database.
     *
     * @var \Doctrine\DBAL\Schema\AbstractSchemaManager
     */
    protected $manager;

    /**
     * Define the connection that will be used.
     *
     * @param Connection $connection
     *
     * @return void
     */
    public function setConnection(Connection $connection)
    {
        $this->builder = $connection->getSchemaBuilder();
        $this->manager = $connection->getDoctrineConnection()->getSchemaManager();
    }

    /**
     * Run the up method to migrate the database structure before test.
     *
     * @return void
     */
    abstract public function up();

    /**
     * Run the down method to reset migrate after test.
     *
     * @return void
     */
    abstract public function down();

    /**
     * Return the expected definition.
     *
     * @param string $driver
     *
     * @return array
     */
    abstract public function getDefinition($driver);

    /**
     * Return the table name created.
     *
     * @return string
     */
    abstract public function getTableName();
}
