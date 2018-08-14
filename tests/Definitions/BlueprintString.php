<?php

namespace Tests\Definitions;

use Illuminate\Database\Schema\Blueprint;

class BlueprintString extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('table_string', function (Blueprint $table) {
            $table->string('default_string');
            $table->string('string_length', 10);
            $table->string('string_max_length', 255);
            $table->string('string_nullable')->nullable();
            $table->string('string_value', 111)->default('Tests using string');
            $table->string('string_comment')->comment('Comment in string');
            $table->string('string_all', 123)->nullable()->default('yes/no')->comment('Other comment in string');
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('table_string');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition($driver)
    {
        $definitions = [
            '$table->string(\'default_string\');',
            '$table->string(\'string_max_length\');',
            '$table->string(\'string_nullable\')->nullable();',
        ];

        // SQLite does not support string length and comment for column.

        if ($driver === 'sqlite') {
            $definitions[] = '$table->string(\'string_length\');';
            $definitions[] = '$table->string(\'string_comment\');';
            $definitions[] = '$table->string(\'string_value\')->default(\'Tests using string\');';
            $definitions[] = '$table->string(\'string_all\')->nullable()->default(\'yes/no\');';
        } else {
            $definitions[] = '$table->string(\'string_length\', 10);';
            $definitions[] = '$table->string(\'string_comment\')->comment(\'Comment in string\');';
            $definitions[] = '$table->string(\'string_value\', 111)->default(\'Tests using string\');';
            $definitions[] = '$table->string(\'string_all\', 123)->nullable()->default(\'yes/no\')->comment(\'Other comment in string\');';
        }

        return $definitions;
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'table_string';
    }
}
