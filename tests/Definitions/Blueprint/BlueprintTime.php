<?php

namespace Tests\Definitions\Blueprint;

use Illuminate\Database\Schema\Blueprint;
use Tests\Definitions\AbstractDefinition;

class BlueprintTime extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('table_time', function (Blueprint $table) {
            $table->time('default_time');
            $table->time('time_nullable')->nullable();
            $table->time('time_value')->default('11:11:11');
            $table->time('time_comment')->comment('Comment in time');
            $table->time('time_all')->nullable()->default('12:12:12')->comment('Other comment in time');
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('table_time');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition($driver)
    {
        $definitions = [
            '$table->time(\'default_time\');',
            '$table->time(\'time_nullable\')->nullable();',
            '$table->time(\'time_value\')->default(\'11:11:11\');',
        ];

        if ($driver === 'sqlite') {
            $definitions[] = '$table->time(\'time_comment\');';
            $definitions[] = '$table->time(\'time_all\')->nullable()->default(\'12:12:12\');';
        } else {
            $definitions[] = '$table->time(\'time_comment\')->comment(\'Comment in time\');';
            $definitions[] = '$table->time(\'time_all\')->nullable()->default(\'12:12:12\')->comment(\'Other comment in time\');';
        }

        return $definitions;
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'table_time';
    }
}
