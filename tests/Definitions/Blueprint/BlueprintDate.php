<?php

namespace Tests\Definitions\Blueprint;

use Illuminate\Database\Schema\Blueprint;
use Tests\Definitions\AbstractDefinition;

class BlueprintDate extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('table_date', function (Blueprint $table) {
            $table->date('default_date');
            $table->date('date_nullable')->nullable();
            $table->date('date_value')->default('2018-01-01');
            $table->date('date_comment')->comment('Comment in date');
            $table->date('date_all')->nullable()->default('2018-12-31')->comment('Other comment in date');
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('table_date');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition($driver)
    {
        $definitions = [
            '$table->date(\'default_date\');',
            '$table->date(\'date_nullable\')->nullable();',
            '$table->date(\'date_value\')->default(\'2018-01-01\');',
        ];

        // SQLite does not support comment for column.

        if ($driver === 'sqlite') {
            $definitions[] = '$table->date(\'date_comment\');';
            $definitions[] = '$table->date(\'date_all\')->nullable()->default(\'2018-12-31\');';
        } else {
            $definitions[] = '$table->date(\'date_comment\')->comment(\'Comment in date\');';
            $definitions[] = '$table->date(\'date_all\')->nullable()->default(\'2018-12-31\')->comment(\'Other comment in date\');';

        }

        return $definitions;
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'table_date';
    }
}
