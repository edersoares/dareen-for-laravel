<?php

namespace Dareen\Definitions;

use Dareen\Signatures\Constraints\UniqueIndexSignature;

class UniqueDefinition extends IndexDefinition
{
    /**
     * Return the index definition.
     *
     * @return array
     */
    public function getDefinition()
    {
        $signature = new UniqueIndexSignature(
            $this->index->getColumns()
        );

        return [
            $signature->sign()
        ];
    }
}
