<?php

namespace Dareen\Signatures;

class IndexSignature extends AbstractSignature
{
    /**
     * Signature name.
     *
     * @var string
     */
    protected $name = 'index';

    /**
     * IndexSignature constructor.
     *
     * @param array $columns
     * @param string|null $name
     */
    public function __construct(array $columns, $name = null)
    {
        $this->addArgument($columns);

        if ($name) {
            $this->addArgument($name);
        }
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

        $arguments = $this->arguments;

        if (is_array($arguments[0]) && count($arguments[0]) === 1) {
            $arguments[0] = array_shift($arguments[0]);
        }

        $arguments = array_map(function ($argument) {
            return $this->convertValue($argument);
        }, $arguments);

        return implode(', ', $arguments);
    }
}
