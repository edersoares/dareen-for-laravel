<?php

namespace Tests\Definitions;

use Illuminate\Database\Schema\Blueprint;

class BlueprintInteger extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('table_integer', function (Blueprint $table) {
            $table->integer('default_integer');
            $table->integer('integer_autoincrement', true);
            $table->integer('integer_nullable')->nullable();
            $table->integer('integer_value')->default(12345);
            $table->integer('integer_comment')->comment('Comment in integer');
            $table->integer('integer_all')->nullable()->default(111)->comment('Other comment in integer');
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('table_integer');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition($driver)
    {
        $definitions = [
            '$table->integer(\'default_integer\');',
            '$table->increments(\'integer_autoincrement\');',
            '$table->integer(\'integer_nullable\')->nullable();',
            '$table->integer(\'integer_value\')->default(12345);',
            '$table->primary(\'integer_autoincrement\');',
        ];

        // SQLite does not support comment for column.

        if ($driver === 'sqlite') {
            $definitions[] = '$table->integer(\'integer_comment\');';
            $definitions[] = '$table->integer(\'integer_all\')->nullable()->default(111);';
        } else {
            $definitions[] = '$table->integer(\'integer_comment\')->comment(\'Comment in integer\');';
            $definitions[] = '$table->integer(\'integer_all\')->nullable()->default(111)->comment(\'Other comment in integer\');';
        }

        return $definitions;
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'table_integer';
    }
}
