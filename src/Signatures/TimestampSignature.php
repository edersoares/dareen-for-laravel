<?php

namespace Dareen\Signatures;

class TimestampSignature extends ColumnSignature
{
    /**
     * @var string
     */
    protected $name = 'timestamp';

    public function __construct($name)
    {
        $this->addArgument($name);
    }
}
