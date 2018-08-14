<?php

namespace Tests\Definitions;

use Illuminate\Database\Schema\Blueprint;

class TableWithCommonColumns extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('common', function (Blueprint $table) {
            $table->boolean('common_boolean');
            $table->date('common_date');
            $table->dateTime('common_datetime');
            $table->decimal('common_decimal');
            $table->float('common_float');
            $table->integer('common_integer');
            $table->string('common_string');
            $table->text('common_text');
            $table->time('common_time');
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
    public function getDefinition($driver)
    {
        $definitions = [
            '$table->boolean(\'common_boolean\');',
            '$table->date(\'common_date\');',
            '$table->dateTime(\'common_datetime\');',
            '$table->float(\'common_float\');',
            '$table->integer(\'common_integer\');',
            '$table->string(\'common_string\');',
            '$table->text(\'common_text\');',
            '$table->time(\'common_time\');',
        ];

        if ($driver === 'sqlite') {
            $definitions[] = '$table->decimal(\'common_decimal\', 10);';
        } else {
            $definitions[] = '$table->decimal(\'common_decimal\');';
        }

        return $definitions;
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'common';
    }
}
