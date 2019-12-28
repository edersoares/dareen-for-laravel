<?php

namespace Dareen\Signatures\Columns;

use Dareen\Signatures\ColumnSignature;

class SoftDeletesSignature extends ColumnSignature
{
    /**
     * @var string
     */
    protected $name = 'softDeletes';

    public function __construct()
    {
        //
    }
}
