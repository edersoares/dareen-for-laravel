<?php

namespace Tests\Definitions\Blueprint;

use Illuminate\Database\Schema\Blueprint;
use Tests\Definitions\AbstractDefinition;

class BlueprintRememberToken extends AbstractDefinition
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('table_remember_token', function (Blueprint $table) {
            $table->rememberToken();
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('table_remember_token');
    }

    /**
     * @inheritDoc
     */
    public function getDefinition($driver)
    {
        return [
            '$table->rememberToken();',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return 'table_remember_token';
    }
}
