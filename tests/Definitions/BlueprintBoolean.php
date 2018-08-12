<?php

namespace Tests\Definitions;

use Illuminate\Database\Schema\Blueprint;

class BlueprintBoolean extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('table_boolean', function (Blueprint $table) {
            $table->boolean('default_boolean');
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('table_boolean');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition($driver)
    {
        return [
            '$table->boolean(\'default_boolean\');',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'table_boolean';
    }
}
