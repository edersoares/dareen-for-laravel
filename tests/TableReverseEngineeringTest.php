<?php

namespace Tests;

use Dareen\Definitions\TableDefinition;
use Dareen\TableReverseEngineering;

class TableReverseEngineeringTest extends TestCase
{
    private $table;

    protected function setUp(): void
    {
        $this->table = $this->createMock(TableDefinition::class);
    }

    public function testGetDefinitionsMethod()
    {
        $tableDefinition = $this->createMock(TableDefinition::class);

        $tableDefinition->method('getColumnsDefinitions')->willReturn([]);
        $tableDefinition->method('getIndexesDefinitions')->willReturn([]);
        $tableDefinition->method('getForeignKeysDefinitions')->willReturn([]);

        /** @var TableDefinition $tableDefinition */
        $table = new TableReverseEngineering($tableDefinition);

        $this->assertEquals(
            [], $table->getDefinitions()
        );
    }

    public function testGetMigrationClassNameMethod()
    {
        $tableDefinition = $this->createMock(TableDefinition::class);

        $tableDefinition->method('getTableName')->willReturn('users');

        /** @var TableDefinition $tableDefinition */
        $table = new TableReverseEngineering($tableDefinition);

        $this->assertEquals(
            'CreateUsersTable', $table->getMigrationClassName()
        );
    }

    public function testGetMigrationClassNameMethodAddForeignKeys()
    {
        $tableDefinition = $this->createMock(TableDefinition::class);

        $tableDefinition->method('getTableName')->willReturn('users');

        /** @var TableDefinition $tableDefinition */
        $table = new TableReverseEngineering($tableDefinition);

        $table->skipColumns();
        $table->skipIndexes();

        $this->assertEquals(
            'AddForeignKeysOnUsersTable', $table->getMigrationClassName()
        );
    }

    public function testGetMigrationClassNameMethodAddIndexes()
    {
        $tableDefinition = $this->createMock(TableDefinition::class);

        $tableDefinition->method('getTableName')->willReturn('users');

        /** @var TableDefinition $tableDefinition */
        $table = new TableReverseEngineering($tableDefinition);

        $table->skipColumns();
        $table->skipForeignKeys();

        $this->assertEquals(
            'AddIndexesOnUsersTable', $table->getMigrationClassName()
        );
    }

    public function testGetMigrationClassNameMethodAlterTable()
    {
        $tableDefinition = $this->createMock(TableDefinition::class);

        $tableDefinition->method('getTableName')->willReturn('users');

        /** @var TableDefinition $tableDefinition */
        $table = new TableReverseEngineering($tableDefinition);

        $table->skipColumns();

        $this->assertEquals(
            'AlterUsersTable', $table->getMigrationClassName()
        );
    }

    public function testGetMigrationFilenameMethod()
    {
        $tableDefinition = $this->createMock(TableDefinition::class);

        $tableDefinition->method('getTableName')->willReturn('users');

        /** @var TableDefinition $tableDefinition */
        $table = new TableReverseEngineering($tableDefinition);

        $find = strpos($table->getMigrationFilename(), 'create_users_table.php');

        $this->assertNotEmpty($find);
    }
}
