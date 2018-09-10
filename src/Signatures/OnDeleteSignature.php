<?php

namespace Dareen\Signatures;

class OnDeleteSignature extends AbstractSignature
{
    /**
     * Signature name.
     *
     * @var string
     */
    protected $name = 'onDelete';

    /**
     * OnUpdateSignature constructor.
     *
     * @param string $action
     */
    public function __construct($action)
    {
        $this->addArgument($action);
    }
}
