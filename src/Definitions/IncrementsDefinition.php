<?php

namespace Dareen\Definitions;

use Dareen\Signatures\IncrementsSignature;

class IncrementsDefinition extends ColumnDefinition
{
    /**
     * Return the index definition.
     *
     * @return array
     */
    public function getDefinition()
    {
        $signature = new IncrementsSignature(
            $this->column->getName()
        );

        return [
            $signature->sign()
        ];
    }
}
