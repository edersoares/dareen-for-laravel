<?php

namespace Dareen\Definitions;

use Doctrine\DBAL\Schema\Column;

trait SpecialTypes
{
    /**
     * Indicate if exists created_at and updated_at columns.
     *
     * @return bool
     */
    public function hasTimestamps()
    {
        $hasCreateAt = false;
        $hasUpdatedAt = false;

        foreach ($this->table->getColumns() as $column) {
            if ($column->getType()->getName() !== 'datetime') {
                continue;
            }

            if ($column->getName() === 'created_at') {
                $hasCreateAt = true;
            }

            if ($column->getName() === 'updated_at') {
                $hasUpdatedAt = true;
            }
        }

        return $hasCreateAt && $hasUpdatedAt;
    }

    /**
     * Indicate if column is increments.
     *
     * @param Column $column
     *
     * @return bool
     */
    public function isIncrements(Column $column)
    {
        $primaryKey = $this->table->getPrimaryKey();

        if (empty($primaryKey)) {
            return false;
        }

        $columns = $primaryKey->getColumns();

        if (count($columns) !== 1) {
            return false;
        }

        if (reset($columns) !== $column->getName()) {
            return false;
        }

        return $column->getAutoincrement();
    }

    /**
     * Indicate if column is rememberToken.
     *
     * @param Column $column
     *
     * @return bool
     */
    public function isRememberToken(Column $column)
    {
        return $column->getName() === 'remember_token'
            && $column->getType()->getName() === 'string';
    }

    public function isTimestamp(Column $column)
    {
        if ($column->getType()->getName() !== 'datetime') {
            return false;
        }

        $defaults = [
            'now()',
        ];

        if (in_array($column->getDefault(), $defaults) === false) {
            return false;
        }

        return true;
    }

    public function isSoftDeletes(Column $column)
    {
        return $column->getName() === 'deleted_at'
            && $column->getType()->getName() === 'datetime';
    }
}
