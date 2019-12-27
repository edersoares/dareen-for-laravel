<?php

namespace Dareen\Definitions;

use Dareen\Signatures\RememberTokenSignature;

class RememberTokenDefinition extends ColumnDefinition
{
    /**
     * Return the index definition.
     *
     * @return array
     */
    public function getDefinition()
    {
        $signature = new RememberTokenSignature();

        return [
            $signature->sign()
        ];
    }
}
