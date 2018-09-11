<?php

namespace Dareen\Signatures;

class ColumnSignature extends AbstractSignature
{
    /**
     * Signature constructor.
     *
     * @param string $name
     * @param array $arguments
     */
    public function __construct($name, array $arguments)
    {
        $this->name = $name;

        foreach ($arguments as $argument) {
            $this->addArgument($argument);
        }
    }
}
