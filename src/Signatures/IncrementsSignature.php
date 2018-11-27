<?php

namespace Dareen\Signatures;

class IncrementsSignature extends ColumnSignature
{
    /**
     * Signature name.
     *
     * @var string
     */
    protected $name = 'increments';

    /**
     * FloatSignature constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->addArgument($name);
    }
}
