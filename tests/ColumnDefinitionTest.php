<?php

namespace Tests;

use Dareen\Definitions\ColumnDefinition;
use Dareen\Definitions\TableDefinition;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Types\Type;

class ColumnDefinitionTest extends TestCase
{
    /**
     * testTypeMethod.
     *
     * @see ColumnDefinition::getTypeName()
     *
     * @return void
     */
    public function testTypeMethod()
    {
        $tableDefinition = $this->createMock(TableDefinition::class);
        $type = $this->createMock(Type::class);
        $column = $this->createMock(Column::class);

        $type->method('getName')->willReturn('integer');
        $column->method('getType')->willReturn($type);

        $columnDefinition = new ColumnDefinition(
            $column, $tableDefinition
        );

        $this->assertEquals('integer', $columnDefinition->getTypeName());
    }

    /**
     * testGetDefinitionMethod.
     *
     * @see ColumnDefinition::getDefinition()
     *
     * @return void
     */
    public function testGetDefinitionMethod()
    {
        $tableDefinition = $this->createMock(TableDefinition::class);
        $type = $this->createMock(Type::class);
        $column = $this->createMock(Column::class);

        $type->method('getName')->willReturn('integer');
        $column->method('getType')->willReturn($type);
        $column->method('getName')->willReturn('id');

        $columnDefinition = new ColumnDefinition(
            $column, $tableDefinition
        );

        $this->assertEquals(
            ['->integer(\'id\')'],
            $columnDefinition->getDefinition()
        );
    }
}
