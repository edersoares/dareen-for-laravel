<?php

namespace Dareen;

use Doctrine\DBAL\Schema\Column;

class ColumnDefinition
{
    /**
     * DBAL Column.
     *
     * @var Column
     */
    private $column;

    /**
     * TableDefinition.
     *
     * @var TableDefinition
     */
    private $table;

    /**
     * ColumnDefinition constructor.
     *
     * @param Column $column
     * @param TableDefinition $table
     */
    public function __construct(Column $column, TableDefinition $table)
    {
        $this->column = $column;
        $this->table = $table;
    }

    /**
     * Return the type name.
     *
     * @return string
     */
    public function getTypeName()
    {
        $type = $this->column->getType()->getName();

        switch ($type) {

            case 'datetime':
                return 'dateTime';

            default:
                return $type;
        }
    }

    /**
     * Return the definitions.
     *
     * @return array
     */
    public function getDefinition()
    {
        $definition = '$table->%s(\'%s\'%s)%s;';

        $type = $this->getTypeName();
        $name = $this->column->getName();
        $length = $this->column->getLength();
        $comment = $this->column->getComment();
        $default = $this->column->getDefault();
        $autoIncrement = $this->column->getAutoincrement();
        $notNull = $this->column->getNotnull();
        $precision = $this->column->getPrecision();
        $scale = $this->column->getScale();

        $modifiers = [];
        $parameters = [];

        if (false === $notNull) {
            $modifiers[] = '->nullable()';
        }

        if (isset($default)) {
            if ($type === 'boolean' ) {
                $value = $default ? 'true' : 'false';
                $modifiers[] = '->default(' . $value . ')';
            } elseif (is_numeric($default)) {
                $modifiers[] = '->default(' . $default . ')';
            } elseif (is_string($default)) {
                $modifiers[] = '->default(\'' . $default . '\')';
            }
        }

        if ($type === 'string') {

            if ($this->column->getFixed()) {
                $type = 'char';
            }

            if ($length > 0 && $length != 255) {
                $parameters[] = ', ' . $length;
            }
        }

        if ($type === 'decimal') {

            if ($precision > 0 && $precision != 8) {
                $parameters[] = ', ' . $precision;
            }

            if ($scale > 0 && $scale != 2) {
                $parameters[] = ', ' . $scale;
            }
        }

        if ($type === 'float' && is_null($length) && $precision > 0) {

            if ($precision > 0 && $precision != 8) {
                $parameters[] = ', ' . $precision;
            }

            if ($scale > 0 && $scale != 2) {
                $parameters[] = ', ' . $scale;
            }
        }

        if ($autoIncrement) {
            $parameters[] = ', true';
        }

        if ($comment) {
            $modifiers[] = '->comment(\'' . $comment . '\')';
        }

        $definition = sprintf(
            $definition,
            $type,
            $name,
            implode('', $parameters),
            implode('', $modifiers)
        );

        return [
            $definition
        ];
    }
}
