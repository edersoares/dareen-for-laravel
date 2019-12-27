<?php

namespace Dareen\Definitions;

use Dareen\Signatures\IncrementsSignature;
use Doctrine\DBAL\Schema\Column;
use Throwable;
use Doctrine\DBAL\Schema\Table;

class TableDefinition
{
    use SpecialTypes;

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

        $this->analyse();
    }

    public function isIncrements(Column $column)
    {
        $primaryKey = $this->table->getPrimaryKey();

        if (empty($primaryKey)) {
            return false;
        }

        $columns = $primaryKey->getColumns();

        if (count($columns) !== 1) {
            return false;
        }

        if (reset($columns) !== $column->getName()) {
            return false;
        }

        return $column->getAutoincrement();
    }

    private function analyse()
    {
        $columns = (array) $this->table->getColumns();

        if ($hasTimestamps = $this->hasTimestamps()) {
            unset($columns['created_at']);
            unset($columns['updated_at']);
        }

        foreach ($columns as $column) {
            if ($this->isIncrements($column)) {
                $this->columns[] = new IncrementsDefinition($column, $this);

                continue;
            }

            $this->columns[] = new ColumnDefinition($column, $this);
        }

        if ($hasTimestamps) {
            $this->columns[] = new TimestampsDefinition($this);
        }

        foreach ((array) $this->table->getIndexes() as $index) {
            if ($index->isPrimary()) {
                if ($this->hasIncrements()) {
                    continue;
                }

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

    public function hasIncrements()
    {
        foreach ($this->columns as $column) {
            if ($column instanceof IncrementsDefinition) {
                return true;
            }
        }

        return false;
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
