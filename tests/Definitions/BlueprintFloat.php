<?php

namespace Tests\Definitions;

use Illuminate\Database\Schema\Blueprint;

class BlueprintFloat extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('table_float', function (Blueprint $table) {
            $table->float('default_float');
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('table_float');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition()
    {
        return [
            '$table->float(\'default_float\');',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'table_float';
    }
}
