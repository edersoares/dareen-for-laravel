<?php

namespace Tests\Definitions\Tables;

use Illuminate\Database\Schema\Blueprint;
use Tests\Definitions\AbstractDefinition;

class TableWithSingleForeignKey extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('basic', function (Blueprint $table) {
            $table->integer('id', true);
        });

        $this->builder->create('single_foreign_key', function (Blueprint $table) {
            $table->integer('basic_id');
            $table->foreign('basic_id')->references('id')->on('basic');
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('single_foreign_key');
        $this->builder->dropIfExists('basic');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition($driver)
    {
        if ($driver === 'sqlite') {
            return [
                '$table->integer(\'basic_id\');',
            ];
        }

        return [
            '$table->integer(\'basic_id\');',
            '$table->foreign(\'basic_id\')->references(\'id\')->on(\'basic\');',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'single_foreign_key';
    }
}
