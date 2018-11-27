<?php

namespace Dareen\Definitions;

use Dareen\Signatures\AbstractSignature;
use Dareen\Signatures\CharSignature;
use Dareen\Signatures\CommentSignature;
use Dareen\Signatures\DecimalSignature;
use Dareen\Signatures\DefaultSignature;
use Dareen\Signatures\FloatSignature;
use Dareen\Signatures\IncrementsSignature;
use Dareen\Signatures\NullableSignature;
use Dareen\Signatures\ColumnSignature;
use Dareen\Signatures\StringSignature;
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
     * Return column signature.
     *
     * @return AbstractSignature
     */
    public function getColumnSignature()
    {
        $type = $this->getTypeName();
        $name = $this->column->getName();
        $length = $this->column->getLength();
        $autoIncrement = $this->column->getAutoincrement();
        $precision = $this->column->getPrecision();
        $scale = $this->column->getScale();

        if ($this->isStringType()) {
            if ($name === 'remember_token') {
                return new ColumnSignature('rememberToken', []);
            }

            return new StringSignature($name, $length);
        }

        if ($this->isCharType()) {
            return new CharSignature($name, $length);
        }

        if ($this->isDecimalType()) {
            return new DecimalSignature($name, $precision, $scale);
        }

        if ($this->isFloatType() && is_null($length) && $precision > 0) {
            return new FloatSignature($name, $precision, $scale);
        }

        if ($autoIncrement) {

            if ($this->table->isPrimaryKey([$name])) {
                return new IncrementsSignature($name);
            }

            return new ColumnSignature($type, [$name, true]);
        }

        return new ColumnSignature($type, [$name]);
    }

    /**
     * Return column modifiers.
     *
     * @return array
     */
    public function getColumnModifiers()
    {
        $modifiers = [];

        $name = $this->column->getName();
        $comment = $this->column->getComment();
        $default = $this->column->getDefault();
        $notNull = $this->column->getNotnull();

        if ($name === 'remember_token') {
            return [];
        }

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
        $name = $this->column->getName();
        $type = $this->column->getType()->getName();

        switch ($type) {

            case 'datetime':

                if ($name === 'email_verified_at') {
                    return 'timestamp';
                }

                return 'dateTime';

            case 'bigint':
                return 'bigInteger';

            case 'smallint':
                return 'smallInteger';

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
        $signature = $this->getColumnSignature();
        $modifiers = implode('', $this->getColumnModifiers());

        return [
            $signature . $modifiers
        ];
    }
}
