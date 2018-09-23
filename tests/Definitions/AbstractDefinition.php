<?php

namespace Tests\Definitions;

use Tests\Migration;

abstract class AbstractDefinition extends Migration
{
    /**
     * Return the expected definition.
     *
     * @param string $driver
     *
     * @return array
     */
    abstract public function getDefinition($driver);

    /**
     * Return the table name created.
     *
     * @return string
     */
    abstract public function getTableName();
}
