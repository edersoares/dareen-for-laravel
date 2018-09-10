<?php

namespace Dareen;

use Dareen\Signatures\ForeignKeySignature;
use Dareen\Signatures\IndexSignature;
use Dareen\Signatures\OnDeleteSignature;
use Dareen\Signatures\OnUpdateSignature;
use Dareen\Signatures\PrimaryIndexSignature;
use Dareen\Signatures\UniqueIndexSignature;
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
     * Create a new line expression.
     *
     * @param string $signature
     *
     * @return string
     */
    private function createExpression($signature)
    {
        return '$table' . $signature . ';';
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
        $columns = $index->getColumns();

        if (in_array($columns, $this->getForeignKeys())) {
            return [];
        }

        $signature = new IndexSignature($columns);

        return [
            $this->createExpression($signature->sign())
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
        $signature = new PrimaryIndexSignature(
            $index->getColumns()
        );

        return [
            $this->createExpression($signature->sign())
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
        $signature = new UniqueIndexSignature(
            $index->getColumns()
        );

        return [
            $this->createExpression($signature->sign())
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
        $signature = new ForeignKeySignature(
            $foreignKey->getColumns(),
            $foreignKey->getForeignColumns(),
            $foreignKey->getForeignTableName()
        );

        $params = [];
        $options = $foreignKey->getOptions();

        if (isset($options['onUpdate'])) {
            $params[] = new OnUpdateSignature($options['onUpdate']);
        }

        if (isset($options['onDelete'])) {
            $params[] = new OnDeleteSignature($options['onDelete']);
        }

        return [
            $this->createExpression($signature->sign() . implode('', $params))
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
