<?php

namespace Dareen;

use Dareen\Definitions\TableDefinition;
use Dareen\Support\MigrationClassNameGenerator;
use DateTime;
use Exception;
use Illuminate\Support\Str;

class TableReverseEngineering
{
    /**
     * Indicate if columns definitions will returned.
     *
     * @var bool
     */
    private $columns = true;

    /**
     * Indicate if indexes definitions will returned.
     *
     * @var bool
     */
    private $indexes = true;

    /**
     * Indicate if foreign keys will returned.
     *
     * @var bool
     */
    private $foreignKeys = true;

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
    }

    /**
     * Return if is a action to create table.
     *
     * @return bool
     */
    public function isCreateTableAction()
    {
        return $this->columns;
    }

    /**
     * Return if is a action to add indexes on table.
     *
     * @return bool
     */
    public function isAddIndexesAction()
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
    public function isAddForeignKeysAction()
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
            'DareenCreateClassName' => 'DareenMigrationClassName',
            'DareenAlterClassName' => 'DareenMigrationClassName',
            '/* DareenUpTable */' => 'DareenUpTable',
            '/* DareenTableName */' => 'DareenTableName',
            '/* DareenMigrationName */' => 'DareenMigrationName',
        ];

        $stub = str_replace(
            array_keys($replaces),
            array_values($replaces),
            $stub
        );

        $replaces = [
            'DareenUpTable' => $this->getTableDefinition(),
            'DareenTableName' => $this->table->getTableName(),
            'DareenMigrationClassName' => $this->getMigrationClassName(),
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
        $generator = new MigrationClassNameGenerator();

        return $generator->generate($this);
    }

    /**
     * Return the migration filename.
     *
     * @param DateTime $date
     *
     * @throws Exception
     *
     * @return string
     */
    public function getMigrationFilename(DateTime $date = null)
    {
        if (is_null($date)) {
            $date = new DateTime();
        }

        $date = $date->format('Y_m_d');
        $name = Str::snake($this->getMigrationClassName());

        return $date . '_000000_' . $name . '.php';
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
     * Return table name.
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->table->getTableName();
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
