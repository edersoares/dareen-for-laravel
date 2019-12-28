<?php

namespace Dareen\Signatures\Modifiers;

use Dareen\Signatures\ModifierSignature;
use Illuminate\Support\Str;

class OnUpdateSignature extends ModifierSignature
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
        $this->addArgument(Str::lower($action));
    }
}
