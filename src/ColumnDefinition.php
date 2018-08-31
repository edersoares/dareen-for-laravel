<?php

namespace Dareen;

use Dareen\Signatures\CommentSignature;
use Dareen\Signatures\DefaultSignature;
use Dareen\Signatures\NullableSignature;
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
     * Return column modifiers.
     *
     * @return array
     */
    private function getColumnModifiers()
    {
        $modifiers = [];

        $comment = $this->column->getComment();
        $default = $this->column->getDefault();
        $notNull = $this->column->getNotnull();

        if (false === $notNull) {
            $modifiers[] = new NullableSignature();
        }

        if (isset($default)) {
            $modifiers[] = new DefaultSignature(
                $this->getTypeName() === 'boolean' ? boolval($default) : $default
            );
        }

        if ($comment) {
            $modifiers[] = new CommentSignature($comment);
        }

        return $modifiers;
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
        $autoIncrement = $this->column->getAutoincrement();
        $precision = $this->column->getPrecision();
        $scale = $this->column->getScale();

        $parameters = [];

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

        $definition = sprintf(
            $definition,
            $type,
            $name,
            implode('', $parameters),
            implode('', $this->getColumnModifiers())
        );

        return [
            $definition
        ];
    }
}
