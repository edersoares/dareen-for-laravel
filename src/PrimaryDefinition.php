<?php

namespace Dareen;

use Dareen\Signatures\PrimaryIndexSignature;

class PrimaryDefinition extends UniqueDefinition
{
    /**
     * Return the index definition.
     *
     * @return array
     */
    public function getDefinition()
    {
        $signature = new PrimaryIndexSignature(
            $this->index->getColumns()
        );

        return [
            '$table' . $signature->sign() . ';'
        ];
    }
}
