<?php

namespace Tests\Definitions;

use Illuminate\Database\Schema\Blueprint;

class BlueprintChar extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('table_char', function (Blueprint $table) {
            $table->char('default_char');
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
        if ($driver === 'sqlite') {
            return [
                '$table->string(\'default_char\');',
            ];
        }

        return [
            '$table->char(\'default_char\');',
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
