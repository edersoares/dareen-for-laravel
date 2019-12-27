<?php

namespace Dareen\Definitions;

use Dareen\Signatures\SoftDeletesSignature;
use Dareen\Signatures\TimestampSignature;

class SoftDeletesDefinition extends TimestampSignature
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
