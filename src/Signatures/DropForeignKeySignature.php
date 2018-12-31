<?php

namespace Dareen\Signatures;

class DropForeignKeySignature extends AbstractSignature
{
    /**
     * Signature name.
     *
     * @var string
     */
    protected $name = 'dropForeign';

    /**
     * DropForeignKeySignature constructor.
     *
     * @param array|string $name
     */
    public function __construct($name)
    {
        $this->addArgument($name);
    }

    /**
     * Return arguments.
     *
     * @return string
     */
    private function getArguments()
    {
        $arguments = $this->arguments;

        if (is_array($arguments[0]) && count($arguments[0]) === 1) {
            return $this->convertValue(array_shift($arguments[0]));
        }

        return $this->convertValue($arguments[0]);
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
            $definition,
            $this->name,
            $this->getArguments()
        );
    }
}
