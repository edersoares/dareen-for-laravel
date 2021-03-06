<?php

namespace Tests\Definitions\Tables;

use Illuminate\Database\Schema\Blueprint;
use Tests\Definitions\AbstractDefinition;

class TableWithDefaultValueForColumn extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('default_value', function (Blueprint $table) {
            $table->decimal('default_decimal')->default(12.34);
            $table->float('default_float')->default(9876.54);
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
    public function getDefinition($driver)
    {
        $definitions = [
            '$table->integer(\'default_integer\')->default(100);',
            '$table->string(\'default_string\')->default(\'string\');',
        ];

        if ($driver === 'sqlite') {
            $definitions[] = '$table->float(\'default_float\', 10)->default(9876.54);';
            $definitions[] = '$table->decimal(\'default_decimal\', 10)->default(12.34);';
        } elseif ($driver === 'pgsql') {
            $definitions[] = '$table->float(\'default_float\', 10)->default(9876.54);';
            $definitions[] = '$table->decimal(\'default_decimal\')->default(12.34);';
        } else {
            $definitions[] = '$table->float(\'default_float\')->default(9876.54);';
            $definitions[] = '$table->decimal(\'default_decimal\')->default(12.34);';
        }

        return $definitions;
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'default_value';
    }
}
