<?php

namespace Dareen\Signatures;

class DefaultSignature extends ModifierSignature
{
    /**
     * Signature name.
     *
     * @var string
     */
    protected $name = 'default';

    /**
     * DefaultSignature constructor.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->addArgument($value);
    }
}
