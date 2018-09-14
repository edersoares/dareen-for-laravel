<?php

namespace Dareen;

use Dareen\Signatures\IndexSignature;
use Doctrine\DBAL\Schema\Index;

class IndexDefinition
{
    /**
     * @var Index
     */
    protected $index;

    /**
     * @var TableDefinition
     */
    protected $table;

    /**
     * IndexDefinition constructor.
     *
     * @param Index $index
     * @param TableDefinition $table
     */
    public function __construct(Index $index, TableDefinition $table)
    {
        $this->index = $index;
        $this->table = $table;
    }

    /**
     * Return the index definition.
     *
     * @return array
     */
    public function getDefinition()
    {
        $columns = $this->index->getColumns();

        if (in_array($columns, $this->table->getForeignKeys())) {
            return [];
        }

        $signature = new IndexSignature($columns);

        return [
            $signature->sign()
        ];
    }
}
