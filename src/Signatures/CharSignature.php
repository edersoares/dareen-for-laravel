<?php

namespace Dareen\Signatures;

use Illuminate\Database\Schema\Builder;

class CharSignature extends ColumnSignature
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

        if ($length && $length !== 255 && $length !== Builder::$defaultStringLength) {
            $this->addArgument($length);
        }
    }
}
