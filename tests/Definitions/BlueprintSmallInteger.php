<?php

namespace Tests\Definitions;

use Illuminate\Database\Schema\Blueprint;

class BlueprintSmallInteger extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('table_small_integer', function (Blueprint $table) {
            $table->smallInteger('default_small_integer');
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('table_small_integer');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition($driver)
    {
        $definitions = [
            '$table->smallInteger(\'default_small_integer\');',
        ];

        if ($driver === 'sqlite') {
            $definitions = [
                '$table->integer(\'default_small_integer\');',
            ];
        }

        return $definitions;
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'table_small_integer';
    }
}
