<?php

namespace Dareen\Definitions;

use Doctrine\DBAL\Schema\AbstractSchemaManager;

class SchemaDefinition
{
    /**
     * DBAL schema manager.
     *
     * @var AbstractSchemaManager
     */
    protected $schema;

    /**
     * SchemaDefinition constructor.
     *
     * @param AbstractSchemaManager $schema
     */
    public function __construct(AbstractSchemaManager $schema)
    {
        $this->schema = $schema;
    }

    /**
     * Return the schema manager.
     *
     * @return AbstractSchemaManager
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * Return the table definition.
     *
     * @param string $name
     *
     * @return TableDefinition
     */
    public function getTableDefinition($name)
    {
        $table = $this->getSchema()->listTableDetails($name);

        return new TableDefinition($table, $this);
    }
}
