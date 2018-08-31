<?php

namespace Dareen\Signatures;

abstract class AbstractSignature
{
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

        if (count($this->arguments) > 1) {
            return $this->convertValue($this->arguments);
        }

        return $this->convertValue($this->arguments[0]);
    }

    /**
     * Convert the value to its respective value type.
     *
     * @param mixed $value
     *
     * @return string
     */
    protected function convertValue($value)
    {
        if (is_numeric($value)) {
            return $value;
        }

        if (is_null($value)) {
            return 'null';
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (is_string($value)) {
            return "'{$value}'";
        }

        if (is_array($value)) {
            $convertedValues = array_map(function ($value) {
                return $this->convertValue($value);
            }, $value);

            return implode(', ', $convertedValues);
        }

        return '';
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
