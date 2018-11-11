<?php

namespace Dareen\Definitions;

use Throwable;
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
     * @var array
     */
    private $columns = [];

    /**
     * @var array
     */
    private $indexes = [];

    /**
     * @var array
     */
    private $foreignKeys = [];

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

        // TODO returns null when mocked

        $cols = [];

        foreach ((array) $this->table->getColumns() as $column) {

            $cols[$column->getName()] = $column->getType();

            $this->columns[] = new ColumnDefinition($column, $this);
        }

        foreach ((array) $this->table->getIndexes() as $index) {
            if ($index->isPrimary()) {
                $this->indexes[] = new PrimaryDefinition($index, $this);
            } elseif ($index->isUnique()) {
                $this->indexes[] = new UniqueDefinition($index, $this);
            } elseif ($index->isSimpleIndex()) {
                $this->indexes[] = new IndexDefinition($index, $this);
            }
        }

        foreach ((array) $this->table->getForeignKeys() as $foreignKey) {
            $this->foreignKeys[] = new ForeignKeyDefinition($foreignKey, $this);
        }
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
        return $this->columns;
    }

    /**
     * Return the indexes definitions.
     *
     * @return IndexDefinition[]
     */
    public function getIndexesDefinitions()
    {
        return $this->indexes;
    }

    /**
     * Return the foreign keys definitions.
     *
     * @return ForeignKeyDefinition[]
     */
    public function getForeignKeysDefinitions()
    {
        return $this->foreignKeys;
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

    /**
     * Return if column or columns is a primary key.
     * 
     * @param array $columns
     *
     * @return bool
     */
    public function isPrimaryKey($columns)
    {
        try {
            $primary = $this->table->getPrimaryKeyColumns();
        } catch (Throwable $throwable) {
            return false;
        }

        sort($columns);
        sort($primary);

        return $columns == $primary;
    }
}
