<?php

namespace Dareen\Signatures;

class CharSignature extends AbstractSignature
{
    /**
     * Signature name.
     *
     * @var string
     */
    protected $name = 'char';

    /**
     * CharSignature constructor.
     *
     * @param string $name
     * @param int|null $length
     */
    public function __construct($name, $length = null)
    {
        $this->addArgument($name);

        if ($length) {
            $this->addArgument($length);
        }
    }
}
