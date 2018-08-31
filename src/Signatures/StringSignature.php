<?php

namespace Dareen\Signatures;

class StringSignature extends AbstractSignature
{
    /**
     * Signature name.
     *
     * @var string
     */
    protected $name = 'string';

    /**
     * StringSignature constructor.
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
