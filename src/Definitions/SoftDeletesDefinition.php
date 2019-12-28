<?php

namespace Dareen\Definitions;

use Dareen\Signatures\SoftDeletesSignature;

class SoftDeletesDefinition extends ColumnDefinition
{
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
