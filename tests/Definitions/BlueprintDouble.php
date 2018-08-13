<?php

namespace Tests\Definitions;

use Illuminate\Database\Schema\Blueprint;

class BlueprintDouble extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('table_double', function (Blueprint $table) {
            $table->double('default_double');
            $table->double('double_total', 7);
            $table->double('double_total_places', 7, 5);
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('table_double');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition($driver)
    {
        // In all platforms double type is unsupported and is converted in
        // float type.

        return [
            '$table->float(\'default_double\');',
            '$table->float(\'double_total\');',
            '$table->float(\'double_total_places\');',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'table_double';
    }
}
