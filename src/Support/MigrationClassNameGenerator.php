<?php

namespace Dareen\Support;

use Dareen\TableReverseEngineering;

class MigrationClassNameGenerator
{
    /**
     * Generate a name for a migration class.
     *
     * @param TableReverseEngineering $table
     *
     * @return string
     */
    public function generate(TableReverseEngineering $table)
    {
        $name = $table->getTableName();

        $name = str_replace('.', '_', $name);
        $name = camel_case($name);
        $name = ucfirst($name);

        if ($table->isCreateTableAction()) {
            $action = 'Create';
        } elseif ($table->isAddForeignKeysAction()) {
            $action = 'AddForeignKeysOn';
        } elseif ($table->isAddIndexesAction()) {
            $action = 'AddIndexesOn';
        }  else {
            $action = 'Alter';
        }

        return $action . $name . 'Table';
    }
}
