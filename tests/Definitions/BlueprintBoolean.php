<?php

namespace Tests\Definitions;

use Illuminate\Database\Schema\Blueprint;

class BlueprintBoolean extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('table_boolean', function (Blueprint $table) {
            $table->boolean('default_boolean');
            $table->boolean('boolean_nullable')->nullable();
            $table->boolean('boolean_true')->default(true);
            $table->boolean('boolean_false')->default(false);
            $table->boolean('boolean_comment')->comment('Comment in boolean');
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('table_boolean');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition($driver)
    {
        $definition = [
            '$table->boolean(\'default_boolean\');',
            '$table->boolean(\'boolean_nullable\')->nullable();',
            '$table->boolean(\'boolean_true\')->default(true);',
            '$table->boolean(\'boolean_false\')->default(false);',
        ];

        if ($driver === 'sqlite') {
            return $definition;
        }

        return array_merge($definition, [
            '$table->boolean(\'boolean_comment\')->comment(\'Comment in boolean\');',
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'table_boolean';
    }
}
