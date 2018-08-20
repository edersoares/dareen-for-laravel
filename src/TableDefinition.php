<?php

namespace Dareen;

use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Doctrine\DBAL\Schema\Index;
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
    private function getForeignKeys()
    {
        $foreignKeys = [];

        foreach ($this->table->getForeignKeys() as $foreignKey) {
            $foreignKeys[] = $foreignKey->getColumns();
        }

        return $foreignKeys;
    }

    /**
     * Return the index definition.
     *
     * @param Index $index
     *
     * @return array
     */
    private function getIndexDefinition(Index $index)
    {
        $definition = '$table->index(%s);';

        $columns = $index->getColumns();

        if (in_array($columns, $this->getForeignKeys())) {
            return [];
        }

        if (count($columns) > 1) {
            $columns = '[\'' . implode('\', \'', $columns) . '\']';
        } else {
            $columns = '\'' . $columns[0] . '\'';
        }

        $definition = sprintf(
            $definition,
            $columns
        );

        return [
            $definition
        ];
    }

    /**
     * Return the primary definition.
     *
     * @param Index $index
     *
     * @return array
     */
    private function getPrimaryDefinition(Index $index)
    {
        $definition = '$table->primary(%s);';

        $columns = $index->getColumns();

        if (count($columns) > 1) {
            $columns = '[\'' . implode('\', \'', $columns) . '\']';
        } else {
            $columns = '\'' . $columns[0] . '\'';
        }

        $definition = sprintf(
            $definition,
            $columns
        );

        return [
            $definition
        ];
    }

    /**
     * Return the unique index definition.
     *
     * @param Index $index
     *
     * @return array
     */
    private function getUniqueDefinition(Index $index)
    {
        $definition = '$table->unique(%s);';

        $columns = $index->getColumns();

        if (count($columns) > 1) {
            $columns = '[\'' . implode('\', \'', $columns) . '\']';
        } else {
            $columns = '\'' . $columns[0] . '\'';
        }

        $definition = sprintf(
            $definition,
            $columns
        );

        return [
            $definition
        ];
    }

    /**
     * Return the foreign definition.
     *
     * @param ForeignKeyConstraint $foreignKey
     *
     * @return array
     */
    private function getForeignDefinition(ForeignKeyConstraint $foreignKey)
    {
        $definition = '$table->foreign(%s)->references(%s)->on(%s)%s;';

        $columns = $foreignKey->getColumns();
        $columnsForeign = $foreignKey->getForeignColumns();
        $table = $foreignKey->getForeignTableName();
        $table = "'{$table}'";

        if (count($columns) > 1) {
            $columns = '[\'' . implode('\', \'', $columns) . '\']';
        } else {
            $columns = '\'' . $columns[0] . '\'';
        }

        if (count($columnsForeign) > 1) {
            $columnsForeign = '[\'' . implode('\', \'', $columnsForeign) . '\']';
        } else {
            $columnsForeign = '\'' . $columnsForeign[0] . '\'';
        }

        $params = [];
        $options = $foreignKey->getOptions();

        if (isset($options['onUpdate'])) {
            $params[] = '->onUpdate(\'' . mb_strtolower($options['onUpdate']) . '\')';
        }

        if (isset($options['onDelete'])) {
            $params[] = '->onDelete(\'' . mb_strtolower($options['onDelete']) . '\')';
        }

        $definition = sprintf(
            $definition,
            $columns,
            $columnsForeign,
            $table,
            implode('', $params)
        );

        return [
            $definition
        ];
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

        foreach ((array) $this->table->getIndexes() as $index) {
            if ($index->isPrimary()) {
                $indexes = array_merge($indexes, $this->getPrimaryDefinition($index));
            } elseif ($index->isUnique()) {
                $indexes = array_merge($indexes, $this->getUniqueDefinition($index));
            } elseif ($index->isSimpleIndex()) {
                $indexes = array_merge($indexes, $this->getIndexDefinition($index));
            }
        }

        foreach ((array) $this->table->getForeignKeys() as $foreignKey) {
            $indexes = array_merge($indexes, $this->getForeignDefinition($foreignKey));
        }
        
        return array_merge($columns, $indexes, $foreign);
    }
}
