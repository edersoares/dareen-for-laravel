<?php

namespace Tests\Definitions;

use Illuminate\Database\Schema\Blueprint;

class TableWithDefaultValueForColumn extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('default_value', function (Blueprint $table) {
            $table->integer('default_integer')->default(100);
            $table->string('default_string')->default('string');
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('default_value');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition()
    {
        return [
            '$table->integer(\'default_integer\')->default(100);',
            '$table->string(\'default_string\')->default(\'string\');'
        ];
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'default_value';
    }
}
