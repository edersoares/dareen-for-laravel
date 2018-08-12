<?php

namespace Tests\Definitions;

use Illuminate\Database\Schema\Blueprint;

class BlueprintInteger extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('table_integer', function (Blueprint $table) {
            $table->integer('default_integer');
            $table->integer('integer_autoincrement', true);
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('table_integer');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition($driver)
    {
        return [
            '$table->integer(\'default_integer\');',
            '$table->integer(\'integer_autoincrement\', true);',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'table_integer';
    }
}
