<?php

namespace Dareen\Signatures;

class OnUpdateSignature extends AbstractSignature
{
    /**
     * Signature name.
     *
     * @var string
     */
    protected $name = 'onUpdate';

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
