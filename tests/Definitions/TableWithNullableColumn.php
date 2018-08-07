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
        $this->builder->dropIfExists('common');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition()
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
