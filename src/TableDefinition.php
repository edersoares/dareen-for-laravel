<?php

namespace Dareen;

use Doctrine\DBAL\Schema\Table;

class TableDefinition
{
    /**
     * DBAL Table.
     *
     * @var Table
     */
    private $table;

    /**
     * SchemaDefinition.
     *
     * @var SchemaDefinition
     */
    private $schema;

    /**
     * TableDefinition constructor.
     *
     * @param Table $table
     * @param SchemaDefinition $schema
     */
    public function __construct(Table $table, SchemaDefinition $schema)
    {
        $this->table = $table;
        $this->schema = $schema;
    }

    /**
     * Return all foreign keys.
     *
     * @return array
     */
    public function getForeignKeys()
    {
        $foreignKeys = [];

        foreach ($this->table->getForeignKeys() as $foreignKey) {
            $foreignKeys[] = $foreignKey->getColumns();
        }

        return $foreignKeys;
    }

    /**
     * Return the columns definitions.
     *
     * @return ColumnDefinition[]
     */
    public function getColumnsDefinitions()
    {
        $columns = [];

        foreach ($this->table->getColumns() as $column) {
            $columns[] = new ColumnDefinition($column, $this);
        }

        return $columns;
    }

    /**
     * Return the indexes definitions.
     *
     * @return array
     */
    public function getIndexesDefinitions()
    {
        $indexes = [];

        foreach ((array) $this->table->getIndexes() as $index) {
            if ($index->isPrimary()) {
                $indexes[] = new PrimaryDefinition($index, $this);
            } elseif ($index->isUnique()) {
                $indexes[] = new UniqueDefinition($index, $this);
            } elseif ($index->isSimpleIndex()) {
                $indexes[] = new IndexDefinition($index, $this);
            }
        }

        return $indexes;
    }

    /**
     * Return the foreign keys definitions.
     *
     * @return array
     */
    public function getForeignKeysDefinitions()
    {
        $foreignKeys = [];

        foreach ((array) $this->table->getForeignKeys() as $foreignKey) {
            $foreignKeys[] = new ForeignKeyDefinition($foreignKey, $this);
        }

        return $foreignKeys;
    }

    /**
     * Return the definitions.
     *
     * @return array
     */
    public function getDefinition()
    {
        $columns = [];
        $indexes = [];
        $foreign = [];

        foreach ($this->getColumnsDefinitions() as $columnDefinition) {
            $columns = array_merge($columns, $columnDefinition->getDefinition());
        }

        foreach ($this->getIndexesDefinitions() as $indexDefinition) {
            $indexes = array_merge($indexes, $indexDefinition->getDefinition());
        }

        foreach ($this->getForeignKeysDefinitions() as $foreignKeyDefinition) {
            $foreign = array_merge($foreign, $foreignKeyDefinition->getDefinition());
        }
        
        $definitions = array_merge($columns, $indexes, $foreign);

        return array_map(function ($definition) {
            return '$table' . $definition . ';';
        }, $definitions);
    }

    /**
     * Return table name.
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->table->getName();
    }
}
