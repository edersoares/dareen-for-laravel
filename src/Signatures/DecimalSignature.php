<?php

namespace Dareen\Signatures;

class DecimalSignature extends ColumnSignature
{
    /**
     * Signature name.
     *
     * @var string
     */
    protected $name = 'decimal';

    /**
     * DecimalSignature constructor.
     *
     * @param string $name
     * @param int $precision
     * @param int $scale
     */
    public function __construct($name, $precision = 8, $scale = 2)
    {
        $this->addArgument($name);

        if ($this->isScaleShown($scale) || $this->isLowPrecision($precision, $scale)) {
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
        return $precision != 8;
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

    /**
     * Determine if precision is a low value.
     *
     * @param int $precision
     * @param int $scale
     *
     * @return bool
     */
    private function isLowPrecision($precision, $scale)
    {
        return $scale === 0 && $precision < 2;
    }
}
