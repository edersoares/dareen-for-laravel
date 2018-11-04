<?php

namespace Tests\Definitions\Blueprint;

use Illuminate\Database\Schema\Blueprint;
use Tests\Definitions\AbstractDefinition;

class BlueprintBigInteger extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('table_big_integer', function (Blueprint $table) {
            $table->bigInteger('default_big_integer');
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('table_big_integer');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition($driver)
    {
        $definitions = [
            '$table->bigInteger(\'default_big_integer\');',
        ];

        if ($driver === 'sqlite') {
            $definitions = [
                '$table->integer(\'default_big_integer\');',
            ];
        }

        return $definitions;
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'table_big_integer';
    }
}
