<?php

namespace Dareen\Signatures\Constraints;

class PrimaryIndexSignature extends UniqueIndexSignature
{
    /**
     * Signature name.
     *
     * @var string
     */
    protected $name = 'primary';
}
