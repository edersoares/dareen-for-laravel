<?php

namespace Tests;

use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Builder;

abstract class Migration
{
    /**
     * Schema builder for migration.
     *
     * @var Builder
     */
    protected $builder;

    /**
     * Schema manager for manipulate the database.
     *
     * @var AbstractSchemaManager
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
}
