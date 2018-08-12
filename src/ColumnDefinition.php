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

        $modifiers = [];
        $parameters = [];

        if (false === $this->column->getNotnull()) {
            $modifiers[] = '->nullable()';
        }

        $default = $this->column->getDefault();

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

        if ($type === 'string' && $this->column->getFixed()) {
            $type = 'char';
        }

        if ($this->column->getAutoincrement()) {
            $parameters[] = ', true';
        }

        $comment = $this->column->getComment();

        if ($comment) {
            $modifiers[] = '->comment(\'' . $comment . '\')';
        }

        $definition = sprintf(
            $definition,
            $type,
            $this->column->getName(),
            implode('', $parameters),
            implode('', $modifiers)
        );

        return [
            $definition
        ];
    }
}
