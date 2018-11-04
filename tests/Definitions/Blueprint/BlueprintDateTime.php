<?php

namespace Tests\Definitions\Blueprint;

use Illuminate\Database\Schema\Blueprint;
use Tests\Definitions\AbstractDefinition;

class BlueprintDateTime extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('table_datetime', function (Blueprint $table) {
            $table->dateTime('default_datetime');
            $table->dateTime('datetime_nullable')->nullable();
            $table->dateTime('datetime_value')->default('2018-01-01 11:11:11');
            $table->dateTime('datetime_comment')->comment('Comment in datetime');
            $table->dateTime('datetime_all')->nullable()->default('2018-12-31 12:12:12')->comment('Other comment in datetime');
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('table_datetime');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition($driver)
    {
        $definitions = [
            '$table->dateTime(\'default_datetime\');',
            '$table->dateTime(\'datetime_nullable\')->nullable();',
            '$table->dateTime(\'datetime_value\')->default(\'2018-01-01 11:11:11\');',
        ];

        // SQLite does not support comment for column.

        if ($driver === 'sqlite') {
            $definitions[] = '$table->dateTime(\'datetime_comment\');';
            $definitions[] = '$table->dateTime(\'datetime_all\')->nullable()->default(\'2018-12-31 12:12:12\');';
        } else {
            $definitions[] = '$table->dateTime(\'datetime_comment\')->comment(\'Comment in datetime\');';
            $definitions[] = '$table->dateTime(\'datetime_all\')->nullable()->default(\'2018-12-31 12:12:12\')->comment(\'Other comment in datetime\');';

        }

        return $definitions;
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'table_datetime';
    }
}
