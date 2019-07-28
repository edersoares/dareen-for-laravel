<?php

namespace Dareen\Support;

use Dareen\TableReverseEngineering;
use Illuminate\Support\Str;

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
        $name = Str::camel($name);
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
