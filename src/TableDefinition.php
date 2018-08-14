<?php

namespace Dareen;

use Doctrine\DBAL\Schema\Column;
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

        return array_merge($columns, $indexes);
    }
}
