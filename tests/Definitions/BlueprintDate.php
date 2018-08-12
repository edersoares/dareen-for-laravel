<?php

namespace Tests\Definitions;

use Illuminate\Database\Schema\Blueprint;

class BlueprintDate extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('table_date', function (Blueprint $table) {
            $table->date('default_date');
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('table_date');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition($driver)
    {
        return [
            '$table->date(\'default_date\');',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'table_date';
    }
}
