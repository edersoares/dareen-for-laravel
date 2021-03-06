<?php

namespace Dareen\Definitions;

use Dareen\Signatures\Columns\SoftDeletesSignature;

class SoftDeletesDefinition extends ColumnDefinition
{
    /**
     * @param TableDefinition $table
     */
    public function __construct(TableDefinition $table)
    {
        $this->table = $table;
    }

    /**
     * Return the index definition.
     *
     * @return array
     */
    public function getDefinition()
    {
        $signature = new SoftDeletesSignature();

        return [
            $signature->sign()
        ];
    }
}
