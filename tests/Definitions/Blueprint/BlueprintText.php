<?php

namespace Tests\Definitions\Blueprint;

use Illuminate\Database\Schema\Blueprint;
use Tests\Definitions\AbstractDefinition;

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
        $definitions = [
            '$table->text(\'default_text\');',
            '$table->text(\'text_nullable\')->nullable();',
        ];

        if ($driver === 'sqlite') {
            $definitions[] = '$table->text(\'text_comment\');';
            $definitions[] = '$table->text(\'text_all\')->nullable();';
        } else {
            $definitions[] = '$table->text(\'text_comment\')->comment(\'Comment in text\');';
            $definitions[] = '$table->text(\'text_all\')->nullable()->comment(\'Other comment in text\');';
        }

        return $definitions;
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'table_text';
    }
}
