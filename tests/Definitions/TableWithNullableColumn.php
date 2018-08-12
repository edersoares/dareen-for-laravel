<?php

namespace Tests\Definitions;

use Illuminate\Database\Schema\Blueprint;

class TableWithNullableColumn extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('nullable', function (Blueprint $table) {
            $table->integer('nullable')->nullable();
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('nullable');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition($driver)
    {
        return [
            '$table->integer(\'nullable\')->nullable();',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'nullable';
    }
}
