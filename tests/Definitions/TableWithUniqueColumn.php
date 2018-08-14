<?php

namespace Tests\Definitions;

use Illuminate\Database\Schema\Blueprint;

class TableWithUniqueColumn extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('unique', function (Blueprint $table) {
            $table->integer('unique_integer')->unique();
            $table->integer('unique_one');
            $table->integer('unique_two');
            $table->integer('unique_three');
            $table->unique(['unique_one', 'unique_two', 'unique_three']);
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('unique');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition($driver)
    {
        return [
            '$table->integer(\'unique_integer\');',
            '$table->integer(\'unique_one\');',
            '$table->integer(\'unique_two\');',
            '$table->integer(\'unique_three\');',
            '$table->unique(\'unique_integer\');',
            '$table->unique([\'unique_one\', \'unique_two\', \'unique_three\']);',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'unique';
    }
}
