<?php

namespace Dareen\Support;

use Dareen\TableReverseEngineering;

class MigrationClassNameGenerator
{
    /**
     * @var TableReverseEngineering
     */
    private $table;

    /**
     * @param TableReverseEngineering $table
     */
    public function __construct(TableReverseEngineering $table)
    {
        $this->table = $table;
    }

    /**
     * Generate a name for a migration class.
     * 
     * @return string
     */
    public function generate()
    {
        $name = $this->table->getTableName();

        $name = str_replace('.', '_', $name);
        $name = camel_case($name);
        $name = ucfirst($name);

        if ($this->table->isCreateTableAction()) {
            $action = 'Create';
        } elseif ($this->table->isAddForeignKeysAction()) {
            $action = 'AddForeignKeysOn';
        } elseif ($this->table->isAddIndexesAction()) {
            $action = 'AddIndexesOn';
        }  else {
            $action = 'Alter';
        }

        return $action . $name . 'Table';
    }
}
