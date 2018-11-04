<?php

namespace Tests\Definitions\Blueprint;

use Illuminate\Database\Schema\Blueprint;
use Tests\Definitions\AbstractDefinition;

class BlueprintChar extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('table_char', function (Blueprint $table) {
            $table->char('default_char');
            $table->char('char_length', 10);
            $table->char('char_max_length', 255);
            $table->char('char_nullable')->nullable();
            $table->char('char_value', 11)->default('tests');
            $table->char('char_comment')->comment('Comment in char');
            $table->char('char_all', 123)->nullable()->default('yes/no')->comment('Other comment in char');
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('table_char');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition($driver)
    {
        // SQLite does not support char type, string length and comment for
        // column.

        if ($driver === 'sqlite') {
            return [
                '$table->string(\'default_char\');',
                '$table->string(\'char_length\');',
                '$table->string(\'char_max_length\');',
                '$table->string(\'char_nullable\')->nullable();',
                '$table->string(\'char_value\')->default(\'tests\');',
                '$table->string(\'char_comment\');',
                '$table->string(\'char_all\')->nullable()->default(\'yes/no\');',
            ];
        }

        return [
            '$table->char(\'default_char\');',
            '$table->char(\'char_length\', 10);',
            '$table->char(\'char_max_length\');',
            '$table->char(\'char_nullable\')->nullable();',
            '$table->char(\'char_value\', 11)->default(\'tests\');',
            '$table->char(\'char_comment\')->comment(\'Comment in char\');',
            '$table->char(\'char_all\', 123)->nullable()->default(\'yes/no\')->comment(\'Other comment in char\');',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'table_char';
    }
}
