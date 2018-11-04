<?php

namespace Tests\Definitions\Blueprint;

use Illuminate\Database\Schema\Blueprint;
use Tests\Definitions\AbstractDefinition;

class BlueprintFloat extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('table_float', function (Blueprint $table) {
            $table->float('default_float');
            $table->float('float_total', 10);
            $table->float('float_total_places', 11, 3);
            $table->float('float_nullable')->nullable();
            $table->float('float_value', 11)->default(12345.67);
            $table->float('float_comment')->comment('Comment in float');
            $table->float('float_all', 11, 4)->nullable()->default(9876.5432)->comment('Other comment in float');
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
    public function getDefinition($driver)
    {
        $definitions = [
            '$table->float(\'default_float\', 10);',
            '$table->float(\'float_total\', 10);',
            '$table->float(\'float_total_places\', 10);',
            '$table->float(\'float_nullable\', 10)->nullable();',
            '$table->float(\'float_value\', 10)->default(12345.67);',
        ];

        if ($driver === 'sqlite') {
            $definitions[] = '$table->float(\'float_comment\', 10);';
            $definitions[] = '$table->float(\'float_all\', 10)->nullable()->default(9876.5432);';
        } elseif ($driver === 'pgsql') {
            $definitions[] = '$table->float(\'float_comment\', 10)->comment(\'Comment in float\');';
            $definitions[] = '$table->float(\'float_all\', 10)->nullable()->default(9876.5432)->comment(\'Other comment in float\');';
        } else {
            $definitions = [
                '$table->float(\'default_float\');',
                '$table->float(\'float_total\', 10);',
                '$table->float(\'float_total_places\', 11, 3);',
                '$table->float(\'float_nullable\')->nullable();',
                '$table->float(\'float_value\', 11)->default(12345.67);',
                '$table->float(\'float_comment\')->comment(\'Comment in float\');',
                '$table->float(\'float_all\', 11, 4)->nullable()->default(9876.5432)->comment(\'Other comment in float\');',
            ];
        }

        return $definitions;
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'table_float';
    }
}
