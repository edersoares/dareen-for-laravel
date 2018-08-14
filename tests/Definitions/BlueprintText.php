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
            $table->text('text_nullable')->nullable();
            $table->text('text_comment')->comment('Comment in text');
            $table->text('text_all')->nullable()->comment('Other comment in text');
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
    public function getDefinition($driver)
    {
        if ($driver === 'sqlite') {
            return [
                '$table->text(\'default_text\');',
                '$table->text(\'text_nullable\')->nullable();',
                '$table->text(\'text_comment\');',
                '$table->text(\'text_all\')->nullable();',
            ];
        }

        return [
            '$table->text(\'default_text\');',
            '$table->text(\'text_nullable\')->nullable();',
            '$table->text(\'text_comment\')->comment(\'Comment in text\');',
            '$table->text(\'text_all\')->nullable()->comment(\'Other comment in text\');',
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
