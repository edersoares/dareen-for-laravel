<?php

namespace Tests\Definitions\Tables;

use Illuminate\Database\Schema\Blueprint;
use Tests\Definitions\AbstractDefinition;

class TableWithCommonColumns extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('common', function (Blueprint $table) {
            $table->increments('common_increments');
            $table->boolean('common_boolean');
            $table->date('common_date');
            $table->dateTime('common_datetime');
            $table->decimal('common_decimal');
            $table->float('common_float');
            $table->integer('common_integer');
            $table->string('common_string');
            $table->text('common_text');
            $table->time('common_time');
            $table->timestamps();
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
            '$table->increments(\'common_increments\');',
            '$table->boolean(\'common_boolean\');',
            '$table->date(\'common_date\');',
            '$table->dateTime(\'common_datetime\');',
            '$table->integer(\'common_integer\');',
            '$table->string(\'common_string\');',
            '$table->text(\'common_text\');',
            '$table->time(\'common_time\');',
            '$table->timestamps();',
        ];

        if ($driver === 'sqlite') {
            $definitions[] = '$table->decimal(\'common_decimal\', 10);';
        } else {
            $definitions[] = '$table->decimal(\'common_decimal\');';
        }

        if ($driver === 'pgsql' || $driver === 'sqlite') {
            $definitions[] = '$table->float(\'common_float\', 10);';
        } else {
            $definitions[] = '$table->float(\'common_float\');';
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
