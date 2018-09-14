<?php

namespace Dareen;

class TableStatement
{
    /**
     * Signatures.
     *
     * @var array
     */
    private $signatures;

    /**
     * TableStatement constructor.
     *
     * @param mixed $signatures
     */
    public function __construct($signatures)
    {
        $this->signatures = func_get_args();
    }

    /**
     * Return a statement as a string.
     *
     * @return string
     */
    public function __toString()
    {
        return '$table' . implode('', $this->signatures) . ';';
    }
}
