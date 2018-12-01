<?php

namespace Dareen\Signatures;

class RememberTokenSignature extends ColumnSignature
{
    /**
     * RememberTokenSignature constructor.
     */
    public function __construct()
    {
        parent::__construct('rememberToken', []);
    }
}
