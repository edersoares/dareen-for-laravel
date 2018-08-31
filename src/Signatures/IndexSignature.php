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

        $first = array_shift($arguments);

        if (is_array($first) && count($first) > 1) {
            $first = '[' . $this->convertValue($first) . ']';
        } else {
            $first = $this->convertValue($first);
        }

        if (empty($arguments)) {
            return $first;
        }

        return $first . ', ' . $this->convertValue($arguments);
    }
}
