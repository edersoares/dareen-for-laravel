<?php

namespace Dareen\Signatures\Columns;

use Dareen\Signatures\ColumnSignature;

class TimestampSignature extends ColumnSignature
{
    /**
     * @var string
     */
    protected $name = 'timestamp';

    /**
     * TimestampSignature constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->addArgument($name);
    }
}
