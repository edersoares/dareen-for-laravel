<?php

namespace Tests\Definitions;

use Dareen\Definitions\ColumnDefinition;
use Dareen\Definitions\SchemaDefinition;
use Dareen\Definitions\TableDefinition;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\Type;
use Tests\TestCase;

class TableDefinitionTest extends TestCase
{
    /**
     * testGetDefinitionMethod.
     *
     * @see TableDefinition::getColumnsDefinitions()
     *
     * @return void
     */
    public function testGetColumnsDefinitionsMethod()
    {
        $table = $this->createMock(Table::class);
        $schemaDefinition = $this->createMock(SchemaDefinition::class);
        $columnId = $this->createMock(Column::class);
        $columnName = $this->createMock(Column::class);

        $columnId->method('getType')->willReturn(
            $this->createMock(IntegerType::class)
        );
        $columnName->method('getType')->willReturn(
            $this->createMock(StringType::class)
        );

        $table->method('getColumns')->willReturn([$columnId, $columnName]);

        $columnDefinition = new TableDefinition(
            $table, $schemaDefinition
        );

        $columns = $columnDefinition->getColumnsDefinitions();

        $this->assertCount(2, $columnDefinition->getColumnsDefinitions());
        $this->assertInstanceOf(ColumnDefinition::class, $columns[0]);
    }

    /**
     * testGetDefinitionMethod.
     *
     * @see TableDefinition::getDefinition()
     *
     * @return void
     */
    public function testGetDefinitionMethod()
    {
        $table = $this->createMock(Table::class);
        $schemaDefinition = $this->createMock(SchemaDefinition::class);
        $typeId = $this->createMock(Type::class);
        $typeName = $this->createMock(Type::class);
        $columnId = $this->createMock(Column::class);
        $columnName = $this->createMock(Column::class);

        $typeId->method('getName')->willReturn('integer');
        $typeName->method('getName')->willReturn('string');
        $columnId->method('getName')->willReturn('id');
        $columnId->method('getType')->willReturn($typeId);
        $columnName->method('getName')->willReturn('name');
        $columnName->method('getType')->willReturn($typeName);
        $table->method('getColumns')->willReturn([$columnId, $columnName]);

        $columnDefinition = new TableDefinition(
            $table, $schemaDefinition
        );

        $this->assertEquals(
            ['$table->integer(\'id\');', '$table->string(\'name\');'],
            $columnDefinition->getDefinition()
        );
    }

    /**
     * testGetDefinitionMethod.
     *
     * @see TableDefinition::getDefinition()
     *
     * @return void
     */
    public function testGetTableNameMethod()
    {
        $table = $this->createMock(Table::class);
        $schemaDefinition = $this->createMock(SchemaDefinition::class);

        $table->method('getColumns')->willReturn([]);
        $table->method('getName')->willReturn('table-name');

        $tableDefinition = new TableDefinition(
            $table, $schemaDefinition
        );

        $this->assertEquals(
            'table-name',
            $tableDefinition->getTableName()
        );
    }

    /**
     * testGetDefinitionMethod.
     *
     * @see TableDefinition::isPrimaryKey()
     *
     * @return void
     */
    public function testIsPrimaryKeyMethod()
    {
        $table = $this->createMock(Table::class);
        $schemaDefinition = $this->createMock(SchemaDefinition::class);

        $table->method('getColumns')->willReturn([]);
        $table->method('getPrimaryKeyColumns')->willReturn(['id']);

        $tableDefinition = new TableDefinition(
            $table, $schemaDefinition
        );

        $this->assertTrue($tableDefinition->isPrimaryKey(['id']));
        $this->assertFalse($tableDefinition->isPrimaryKey(['id', 'other_id']));
        $this->assertFalse($tableDefinition->isPrimaryKey([null]));
    }
}
