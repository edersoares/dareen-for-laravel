<?php

namespace Dareen\Signatures\Columns;

use Dareen\Signatures\ColumnSignature;

class FloatSignature extends ColumnSignature
{
    /**
     * Signature name.
     *
     * @var string
     */
    protected $name = 'float';

    /**
     * FloatSignature constructor.
     *
     * @param string $name
     * @param int $precision
     * @param int $scale
     */
    public function __construct($name, $precision = 8, $scale = 2)
    {
        $this->addArgument($name);

        if ($this->isScaleShown($scale)) {
            $this->addArgument($precision);
            $this->addArgument($scale);
        } elseif ($this->isPrecisionShown($precision)) {
            $this->addArgument($precision);
        }
    }

    /**
     * Determine if precision is shown.
     *
     * @param int $precision
     *
     * @return bool
     */
    private function isPrecisionShown($precision)
    {
        return $precision > 0 && $precision != 8;
    }

    /**
     * Determine if scale is shown.
     *
     * @param int $scale
     *
     * @return bool
     */
    private function isScaleShown($scale)
    {
        return $scale > 0 && $scale != 2;
    }
}
