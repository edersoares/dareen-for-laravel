<?php

namespace Dareen;

use Dareen\Signatures\ForeignKeySignature;
use Dareen\Signatures\OnDeleteSignature;
use Dareen\Signatures\OnUpdateSignature;
use Doctrine\DBAL\Schema\ForeignKeyConstraint;

class ForeignKeyDefinition
{
    /**
     * DBAL foreign key.
     *
     * @var ForeignKeyConstraint
     */
    private $foreignKey;

    /**
     * TableDefinition.
     *
     * @var TableDefinition
     */
    private $table;

    /**
     * ForeignKeyDefinition constructor.
     *
     * @param ForeignKeyConstraint $foreignKey
     * @param TableDefinition $table
     */
    public function __construct(ForeignKeyConstraint $foreignKey, TableDefinition $table)
    {
        $this->foreignKey = $foreignKey;
        $this->table = $table;
    }

    /**
     * Return the definitions.
     *
     * @return array
     */
    public function getDefinition()
    {
        $signature = new ForeignKeySignature(
            $this->foreignKey->getColumns(),
            $this->foreignKey->getForeignColumns(),
            $this->foreignKey->getForeignTableName()
        );

        $params = [];
        $options = $this->foreignKey->getOptions();

        if (isset($options['onUpdate'])) {
            $params[] = new OnUpdateSignature($options['onUpdate']);
        }

        if (isset($options['onDelete'])) {
            $params[] = new OnDeleteSignature($options['onDelete']);
        }

        return [
            $signature->sign() . implode('', $params)
        ];
    }
}
