<?php

namespace Dareen\Signatures;

class ForeignKeySignature extends AbstractSignature
{
    /**
     * Signature name.
     *
     * @var string
     */
    protected $name = 'foreign';

    /**
     * ForeignKeySignature constructor.
     *
     * @param array|string $columns
     * @param array|string $referencedColumns
     * @param string $referencedTable
     */
    public function __construct($columns, $referencedColumns, $referencedTable)
    {
        $this->addArgument($columns);
        $this->addArgument($referencedColumns);
        $this->addArgument($referencedTable);
    }

    /**
     * Return local columns.
     *
     * @return string
     */
    private function getColumns()
    {
        $arguments = $this->arguments;

        if (is_array($arguments[0]) && count($arguments[0]) === 1) {
            return $this->convertValue(array_shift($arguments[0]));
        }

        return $this->convertValue($arguments[0]);
    }

    /**
     * Return referenced columns.
     *
     * @return string
     */
    private function getReferencedColumns()
    {
        $arguments = $this->arguments;

        if (is_array($arguments[1]) && count($arguments[1]) === 1) {
            return $this->convertValue(array_shift($arguments[1]));
        }

        return $this->convertValue($arguments[1]);
    }

    /**
     * Return referenced table.
     *
     * @return string
     */
    private function getReferencedTable()
    {
        return $this->convertValue($this->arguments[2]);
    }

    /**
     * Return the signature.
     *
     * @return string
     */
    public function sign()
    {
        $definition = '->%s(%s)->references(%s)->on(%s)';

        return sprintf(
            $definition,
            $this->name,
            $this->getColumns(),
            $this->getReferencedColumns(),
            $this->getReferencedTable()
        );
    }
}
