<?php

namespace Tests\Definitions\Tables;

use Illuminate\Database\Schema\Blueprint;
use Tests\Definitions\AbstractDefinition;

class TableWithCompositeForeignKey extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('basic', function (Blueprint $table) {
            $table->integer('one');
            $table->integer('two');
            $table->primary(['one', 'two']);
        });

        $this->builder->create('single_foreign_key', function (Blueprint $table) {
            $table->integer('basic_one');
            $table->integer('basic_two');
            $table->foreign(['basic_one', 'basic_two'])->references(['one', 'two'])->on('basic')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('single_foreign_key');
        $this->builder->dropIfExists('basic');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition($driver)
    {
        // DBAL SQLite support does not understand foreign keys

        if ($driver === 'sqlite') {
            return [
                '$table->integer(\'basic_one\');',
                '$table->integer(\'basic_two\');',
            ];
        }

        return [
            '$table->integer(\'basic_one\');',
            '$table->integer(\'basic_two\');',
            '$table->foreign([\'basic_one\', \'basic_two\'])->references([\'one\', \'two\'])->on(\'basic\')->onUpdate(\'cascade\')->onDelete(\'cascade\');',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'single_foreign_key';
    }
}
