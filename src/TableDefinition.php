<?php

namespace Dareen;

use Doctrine\DBAL\Schema\Column;
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
        return collect($this->table->getForeignKeys())->map(function (ForeignKeyConstraint $constraint) {
            return $constraint->getColumns();
        })->toArray();
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
        $definition = '$table->foreign(%s)->references(%s)->on(%s);';

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

        $definition = sprintf(
            $definition,
            $columns,
            $columnsForeign,
            $table
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
        return array_map(function (Column $column) {
            return new ColumnDefinition($column, $this);
        }, $this->table->getColumns());
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
