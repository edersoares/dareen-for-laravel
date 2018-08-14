<?php

namespace Tests\Definitions;

use Illuminate\Database\Schema\Blueprint;

class TableWithCompositePrimaryKey extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('composite_primary', function (Blueprint $table) {
            $table->integer('one');
            $table->integer('two');
            $table->integer('three');
            $table->primary(['one', 'two', 'three']);
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('composite_primary');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition($driver)
    {
        return [
            '$table->integer(\'one\');',
            '$table->integer(\'two\');',
            '$table->integer(\'three\');',
            '$table->primary([\'one\', \'two\', \'three\']);',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'composite_primary';
    }
}
