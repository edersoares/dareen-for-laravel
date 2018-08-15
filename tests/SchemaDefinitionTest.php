<?php

namespace Tests;

use Tests\Definitions\BasicTableWithOneColumn;
use Tests\Definitions\BlueprintBoolean;
use Tests\Definitions\BlueprintChar;
use Tests\Definitions\BlueprintDate;
use Tests\Definitions\BlueprintDateTime;
use Tests\Definitions\BlueprintDecimal;
use Tests\Definitions\BlueprintDouble;
use Tests\Definitions\BlueprintFloat;
use Tests\Definitions\BlueprintInteger;
use Tests\Definitions\BlueprintString;
use Tests\Definitions\BlueprintText;
use Tests\Definitions\BlueprintTime;
use Tests\Definitions\TableWithCommonColumns;
use Tests\Definitions\TableWithCompositePrimaryKey;
use Tests\Definitions\TableWithDefaultValueForColumn;
use Tests\Definitions\TableWithIndexColumn;
use Tests\Definitions\TableWithNullableColumn;
use Tests\Definitions\TableWithSingleForeignKey;
use Tests\Definitions\TableWithSinglePrimaryKey;
use Tests\Definitions\TableWithUniqueColumn;

class SchemaDefinitionTest extends TestCase
{
    use SchemaDefinitionRunner;

    /**
     * @see BasicTableWithOneColumn
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testWithOneColumn()
    {
        $this->runSchemaDefinitionTestFor(
            new BasicTableWithOneColumn()
        );
    }

    /**
     * @see TableWithCommonColumns
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testWithCommonColumns()
    {
        $this->runSchemaDefinitionTestFor(
            new TableWithCommonColumns()
        );
    }

    /**
     * @see TableWithNullableColumn
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testWithNullableColumn()
    {
        $this->runSchemaDefinitionTestFor(
            new TableWithNullableColumn()
        );
    }

    /**
     * @see TableWithDefaultValueForColumn
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testWithDefaultValueForColumn()
    {
        $this->runSchemaDefinitionTestFor(
            new TableWithDefaultValueForColumn()
        );
    }

    /**
     * @see TableWithIndexColumn
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testWithIndexColumn()
    {
        $this->runSchemaDefinitionTestFor(
            new TableWithIndexColumn()
        );
    }

    /**
     * @see TableWithSinglePrimaryKey
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testWithSinglePrimaryKey()
    {
        $this->runSchemaDefinitionTestFor(
            new TableWithSinglePrimaryKey()
        );
    }

    /**
     * @see TableWithCompositePrimaryKey
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testWithCompositePrimaryKey()
    {
        $this->runSchemaDefinitionTestFor(
            new TableWithCompositePrimaryKey()
        );
    }

    /**
     * @see TableWithSingleForeignKey
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testWithSingleForeignKey()
    {
        $this->runSchemaDefinitionTestFor(
            new TableWithSingleForeignKey()
        );
    }

    /**
     * @see TableWithUniqueColumn
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testWithUniqueColumn()
    {
        $this->runSchemaDefinitionTestFor(
            new TableWithUniqueColumn()
        );
    }

    /**
     * @see BlueprintInteger
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testBlueprintInteger()
    {
        $this->runSchemaDefinitionTestFor(
            new BlueprintInteger()
        );
    }

    /**
     * @see BlueprintFloat
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testBlueprintFloat()
    {
        $this->runSchemaDefinitionTestFor(
            new BlueprintFloat()
        );
    }

    /**
     * @see BlueprintDecimal
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testBlueprintDecimal()
    {
        $this->runSchemaDefinitionTestFor(
            new BlueprintDecimal()
        );
    }

    /**
     * @see BlueprintString
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testBlueprintString()
    {
        $this->runSchemaDefinitionTestFor(
            new BlueprintString()
        );
    }

    /**
     * @see BlueprintText
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testBlueprintText()
    {
        $this->runSchemaDefinitionTestFor(
            new BlueprintText()
        );
    }

    /**
     * @see BlueprintChar
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testBlueprintChar()
    {
        $this->runSchemaDefinitionTestFor(
            new BlueprintChar()
        );
    }

    /**
     * @see BlueprintDouble
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testBlueprintDouble()
    {
        $this->runSchemaDefinitionTestFor(
            new BlueprintDouble()
        );
    }

    /**
     * @see BlueprintBoolean
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testBlueprintBoolean()
    {
        $this->runSchemaDefinitionTestFor(
            new BlueprintBoolean()
        );
    }

    /**
     * @see BlueprintDate
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testBlueprintDate()
    {
        $this->runSchemaDefinitionTestFor(
            new BlueprintDate()
        );
    }

    /**
     * @see BlueprintDateTime
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testBlueprintDateTime()
    {
        $this->runSchemaDefinitionTestFor(
            new BlueprintDateTime()
        );
    }

    /**
     * @see BlueprintTime
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testBlueprintTime()
    {
        $this->runSchemaDefinitionTestFor(
            new BlueprintTime()
        );
    }
}
