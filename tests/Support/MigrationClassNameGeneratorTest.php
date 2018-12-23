<?php

namespace Tests\Support;

use Dareen\Support\MigrationClassNameGenerator;
use Dareen\TableReverseEngineering;
use PHPUnit\Framework\TestCase;

class MigrationClassNameGeneratorTest extends TestCase
{
    public function testCreateNaming()
    {
        $table = $this->createMock(TableReverseEngineering::class);

        $table->method('getTableName')->willReturn('users');
        $table->method('isCreateTableAction')->willReturn(true);
        $table->method('isAddForeignKeysAction')->willReturn(false);
        $table->method('isAddIndexesAction')->willReturn(false);

        $generator = new MigrationClassNameGenerator();

        $name = $generator->generate($table);

        $this->assertEquals('CreateUsersTable', $name);
    }

    public function testForeignKeyNaming()
    {
        $table = $this->createMock(TableReverseEngineering::class);

        $table->method('getTableName')->willReturn('users');
        $table->method('isCreateTableAction')->willReturn(false);
        $table->method('isAddForeignKeysAction')->willReturn(true);
        $table->method('isAddIndexesAction')->willReturn(false);

        $generator = new MigrationClassNameGenerator();

        $name = $generator->generate($table);

        $this->assertEquals('AddForeignKeysOnUsersTable', $name);
    }
}
