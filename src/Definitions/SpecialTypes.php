<?php

namespace Dareen\Definitions;

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
}
