<?php

namespace Dareen;

use Dareen\Definitions\SchemaDefinition;
use Doctrine\DBAL\Connection;

class ReverseEngineering
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var SchemaDefinition
     */
    private $schema;

    /**
     * ReverseEngineering constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;

        $this->schema = new SchemaDefinition(
            $connection->getSchemaManager()
        );
    }

    /**
     * Do reverse engineering from table.
     *
     * @param string $name
     *
     * @return TableReverseEngineering
     */
    public function table($name)
    {
        return new TableReverseEngineering(
            $this->schema->getTableDefinition($name)
        );
    }
}
