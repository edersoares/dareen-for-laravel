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
        $definition = '$table->%s(\'%s\')%s;';

        $modifiers = [];

        if (false === $this->column->getNotnull()) {
            $modifiers[] = '->nullable()';
        }

        $definition = sprintf(
            $definition,
            $this->getTypeName(),
            $this->column->getName(),
            implode('', $modifiers)
        );

        return [
            $definition
        ];
    }
}
