<?php

namespace Tests\Definitions;

use Illuminate\Database\Schema\Blueprint;

class TableWithIndexColumn extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('index', function (Blueprint $table) {
            $table->integer('index_integer')->index();
            $table->integer('index_one');
            $table->integer('index_two');
            $table->integer('index_three');
            $table->index(['index_one', 'index_two', 'index_three']);
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('index');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition($driver)
    {
        return [
            '$table->integer(\'index_integer\');',
            '$table->integer(\'index_one\');',
            '$table->integer(\'index_two\');',
            '$table->integer(\'index_three\');',
            '$table->index(\'index_integer\');',
            '$table->index([\'index_one\', \'index_two\', \'index_three\']);',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'index';
    }
}
