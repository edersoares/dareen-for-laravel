<?php

namespace Dareen\Signatures\Columns;

use Dareen\Signatures\ColumnSignature;
use Illuminate\Database\Schema\Builder;

class StringSignature extends ColumnSignature
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

        if ($length && $length !== 255 && $length !== Builder::$defaultStringLength) {
            $this->addArgument($length);
        }
    }
}
