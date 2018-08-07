<?php

namespace Tests\Definitions;

use Illuminate\Database\Schema\Blueprint;

class BasicTableWithOneColumn extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('basic', function (Blueprint $table) {
            $table->integer('basic');
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('basic');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition()
    {
        return [
            '$table->integer(\'basic\');',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'basic';
    }
}
