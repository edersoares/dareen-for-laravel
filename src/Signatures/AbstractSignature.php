<?php

namespace Dareen\Signatures;

use Dareen\Support\ValueConverter;

abstract class AbstractSignature
{
    use ValueConverter;

    /**
     * Signature name.
     *
     * @var string
     */
    protected $name;

    /**
     * Signature arguments.
     *
     * @var array
     */
    protected $arguments;

    /**
     * Return the signature.
     *
     * @see AbstractSignature::sign()
     *
     * @return string
     */
    public function __toString()
    {
        return $this->sign();
    }

    /**
     * Add one argument for signature.
     *
     * @param mixed $argument
     *
     * @return void
     */
    protected function addArgument($argument)
    {
        $this->arguments[] = $argument;
    }

    /**
     * Return the arguments definition.
     *
     * @return string
     */
    protected function getArgumentsSignature()
    {
        if (empty($this->arguments)) {
            return '';
        }

        $arguments = array_map(function ($argument) {
            return $this->convertValue($argument);
        }, $this->arguments);

        return implode(', ', $arguments);
    }

    /**
     * Return the signature.
     *
     * @return string
     */
    public function sign()
    {
        $definition = '->%s(%s)';

        return sprintf(
            $definition, $this->name, $this->getArgumentsSignature()
        );
    }
}
