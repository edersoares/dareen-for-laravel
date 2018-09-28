<?php

namespace Tests\Definitions;

use Illuminate\Database\Schema\Blueprint;

class BlueprintDecimal extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('table_decimal', function (Blueprint $table) {
            $table->decimal('default_decimal');
            $table->decimal('decimal_total', 10);
            $table->decimal('decimal_total_places', 11, 3);
            $table->decimal('decimal_nullable')->nullable();
            $table->decimal('decimal_value')->default(123.45);
            $table->decimal('decimal_comment')->comment('Comment in decimal');
            $table->decimal('decimal_all', 12, 4)->nullable()->default(9876.5432)->comment('Other comment in decimal');
            $table->decimal('default_decimal_one_zero', 1, 0);
            $table->decimal('default_decimal_one_one', 1, 1);
            $table->decimal('default_decimal_two_one', 2, 1);
            $table->decimal('default_decimal_two_two', 2, 2);
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('table_decimal');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition($driver)
    {
        if ($driver === 'sqlite') {
            return [
                '$table->decimal(\'default_decimal\', 10);',
                '$table->decimal(\'decimal_total\', 10);',
                '$table->decimal(\'decimal_total_places\', 10);',
                '$table->decimal(\'decimal_nullable\', 10)->nullable();',
                '$table->decimal(\'decimal_value\', 10)->default(123.45);',
                '$table->decimal(\'decimal_comment\', 10);',
                '$table->decimal(\'decimal_all\', 10)->nullable()->default(9876.5432);',
                '$table->decimal(\'default_decimal_one_zero\', 10);',
                '$table->decimal(\'default_decimal_one_one\', 10);',
                '$table->decimal(\'default_decimal_two_one\', 10);',
                '$table->decimal(\'default_decimal_two_two\', 10);',
            ];
        }

        return [
            '$table->decimal(\'default_decimal\');',
            '$table->decimal(\'decimal_total\', 10);',
            '$table->decimal(\'decimal_total_places\', 11, 3);',
            '$table->decimal(\'decimal_nullable\')->nullable();',
            '$table->decimal(\'decimal_value\')->default(123.45);',
            '$table->decimal(\'decimal_comment\')->comment(\'Comment in decimal\');',
            '$table->decimal(\'decimal_all\', 12, 4)->nullable()->default(9876.5432)->comment(\'Other comment in decimal\');',
            '$table->decimal(\'default_decimal_one_zero\', 1, 0);',
            '$table->decimal(\'default_decimal_one_one\', 1, 1);',
            '$table->decimal(\'default_decimal_two_one\', 2, 1);',
            '$table->decimal(\'default_decimal_two_two\', 2);',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'table_decimal';
    }
}
