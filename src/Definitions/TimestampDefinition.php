<?php

namespace Dareen\Definitions;

use Dareen\Signatures\Columns\TimestampSignature;

class TimestampDefinition extends ColumnDefinition
{
    /**
     * Return the index definition.
     *
     * @return array
     */
    public function getDefinition()
    {
        $signature = new TimestampSignature(
            $this->column->getName(), []
        );

        return [
            $signature->sign()
        ];
    }
}
