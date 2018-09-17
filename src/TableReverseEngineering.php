<?php

namespace Dareen;

use Dareen\Definitions\TableDefinition;

class TableReverseEngineering
{
    /**
     * Indicate if columns definitions will returned.
     *
     * @var bool
     */
    private $columns = false;

    /**
     * Indicate if indexes definitions will returned.
     *
     * @var bool
     */
    private $indexes = false;

    /**
     * Indicate if foreign keys will returned.
     *
     * @var bool
     */
    private $foreignKeys = false;

    /**
     * Table definition.
     *
     * @var TableDefinition
     */
    private $table;

    /**
     * TableReverseEngineering constructor.
     *
     * @param TableDefinition $table
     */
    public function __construct(TableDefinition $table)
    {
        $this->table = $table;
        $this->columns = true;
        $this->indexes = true;
        $this->foreignKeys = true;
    }

    /**
     * Return if is a action to create table.
     *
     * @return bool
     */
    private function isCreateTableAction()
    {
        return $this->columns;
    }

    /**
     * Return if is a action to add indexes on table.
     *
     * @return bool
     */
    private function isAddIndexesAction()
    {
        return $this->indexes
            && $this->columns === false
            && $this->foreignKeys === false;
    }

    /**
     * Return if is a action to add foreign keys on table.
     *
     * @return bool
     */
    private function isAddForeignKeysAction()
    {
        return $this->foreignKeys
            && $this->columns === false
            && $this->indexes === false;
    }

    /**
     * Skip the columns in migration.
     *
     * @return $this
     */
    public function skipColumns()
    {
        $this->columns = false;

        return $this;
    }

    /**
     * Skip the indexes in migration.
     *
     * @return $this
     */
    public function skipIndexes()
    {
        $this->indexes = false;

        return $this;
    }

    /**
     * Skip the foreign keys in migration.
     *
     * @return $this
     */
    public function skipForeignKeys()
    {
        $this->foreignKeys = false;

        return $this;
    }

    /**
     * Return the migrations definitions.
     *
     * @return string
     */
    public function getMigration()
    {
        $stub = $this->getStubForCreateTable();

        $replaces = [
            '/* DareenReplaceTableDefinition */' => 'DareenReplaceTableDefinition',
            '/* DareenReplaceTableName */' => 'DareenReplaceTableName',
            '/* DareenReplaceMigrationName */' => 'DareenReplaceMigrationName',
        ];

        $stub = str_replace(
            array_keys($replaces),
            array_values($replaces),
            $stub
        );

        $replaces = [
            'DareenReplaceTableDefinition' => $this->getTableDefinition(),
            'DareenReplaceTableName' => $this->table->getTableName(),
            'DareenReplaceMigrationClassName' => $this->getMigrationClassName(),
        ];

        return str_replace(
            array_keys($replaces),
            array_values($replaces),
            $stub
        );
    }

    /**
     * Return the migration class name.
     *
     * @return string
     */
    public function getMigrationClassName()
    {
        $name = $this->table->getTableName();

        $name = str_replace('.', '_', $name);
        $name = camel_case($name);
        $name = ucfirst($name);

        if ($this->isCreateTableAction()) {
            $action = 'Create';
        } elseif ($this->isAddForeignKeysAction()) {
            $action = 'AddForeignKeysOn';
        } elseif ($this->isAddIndexesAction()) {
            $action = 'AddIndexesOn';
        }  else {
            $action = 'Alter';
        }

        return $action . $name . 'Table';
    }

    /**
     * Return the migration filename.
     *
     * @return string
     */
    public function getMigrationFilename()
    {
        $date = date('Y_m_d_His');
        $name = snake_case($this->getMigrationClassName());

        return $date . '_' . $name . '.php';
    }

    /**
     * Return the migrations definitions.
     *
     * @return array
     */
    public function getDefinitions()
    {
        $columns = [];
        $indexes = [];
        $foreign = [];

        if ($this->columns) {
            foreach ($this->table->getColumnsDefinitions() as $columnDefinition) {
                $columns = array_merge($columns, $columnDefinition->getDefinition());
            }
        }

        if ($this->indexes) {
            foreach ($this->table->getIndexesDefinitions() as $indexDefinition) {
                $indexes = array_merge($indexes, $indexDefinition->getDefinition());
            }
        }

        if ($this->foreignKeys) {
            foreach ($this->table->getForeignKeysDefinitions() as $foreignKeyDefinition) {
                $foreign = array_merge($foreign, $foreignKeyDefinition->getDefinition());
            }
        }

        $definitions = array_merge($columns, $indexes, $foreign);

        return array_map(function ($definition) {
            return '$table' . $definition . ';';
        }, $definitions);
    }

    /**
     * Return table definition.
     *
     * @return string
     */
    public function getTableDefinition()
    {
        $defs = $this->getDefinitions();
        $total = count($defs);

        for ($i = 1; $i < $total; $i++) {
            $defs[$i] = "            {$defs[$i]}";

        }

        return implode("\n", $defs);
    }

    /**
     * Return stub for create table.
     *
     * @return string
     */
    public function getStubForCreateTable()
    {
        return file_get_contents(__DIR__ . '/../stubs/create-table.php');
    }

    /**
     * Return stub for alter table.
     *
     * @return string
     */
    public function getStubForAlterTable()
    {
        return file_get_contents(__DIR__ . '/../stubs/alter-table.php');
    }
}
