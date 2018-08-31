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
    public function getColumnModifiers()
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
     * Determine if is the column type.
     *
     * @param string $type
     *
     * @return bool
     */
    public function isType($type)
    {
        return $this->getTypeName() === $type;
    }

    /**
     * Return if is a string column.
     *
     * @return bool
     */
    public function isStringType()
    {
        return $this->isType('string') && $this->column->getFixed() === false;
    }

    /**
     * Return if is a char column.
     *
     * @return bool
     */
    public function isCharType()
    {
        return $this->isType('string') && $this->column->getFixed();
    }

    /**
     * Return if is a decimal column.
     *
     * @return bool
     */
    public function isDecimalType()
    {
        return $this->isType('decimal');
    }

    /**
     * Return if is a float column.
     *
     * @return bool
     */
    public function isFloatType()
    {
        return $this->isType('float');
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

        if ($this->isStringType() && $length > 0 && $length != 255) {
            $parameters[] = ', ' . $length;
        }

        if ($this->isCharType()) {
            $type = 'char';

            if ($length > 0 && $length != 255) {
                $parameters[] = ', ' . $length;
            }
        }

        if ($this->isDecimalType()) {

            if ($precision > 0 && $precision != 8) {
                $parameters[] = ', ' . $precision;
            }

            if ($scale > 0 && $scale != 2) {
                $parameters[] = ', ' . $scale;
            }
        }

        if ($this->isFloatType() && is_null($length) && $precision > 0) {

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
