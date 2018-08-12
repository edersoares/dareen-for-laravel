<?php

namespace Tests\Definitions;

use Illuminate\Database\Schema\Blueprint;

class BlueprintText extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('table_text', function (Blueprint $table) {
            $table->text('default_text');
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('table_text');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition()
    {
        return [
            '$table->text(\'default_text\');',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'table_text';
    }
}
