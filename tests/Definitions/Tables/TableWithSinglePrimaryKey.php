<?php

namespace Tests\Definitions\Tables;

use Illuminate\Database\Schema\Blueprint;
use Tests\Definitions\AbstractDefinition;

class TableWithSinglePrimaryKey extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('single_primary', function (Blueprint $table) {
            $table->integer('single')->primary();
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('single_primary');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition($driver)
    {
        // SQLite's primary key always will be autoincrement

        if ($driver === 'sqlite') {
            return [
                '$table->increments(\'single\');',
            ];
        }

        return [
            '$table->integer(\'single\');',
            '$table->primary(\'single\');',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'single_primary';
    }
}
