<?php

namespace Tests\Definitions;

use Illuminate\Database\Schema\Blueprint;

class BlueprintDateTime extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('table_datetime', function (Blueprint $table) {
            $table->dateTime('default_datetime');
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('table_datetime');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition($driver)
    {
        return [
            '$table->dateTime(\'default_datetime\');',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'table_datetime';
    }
}
