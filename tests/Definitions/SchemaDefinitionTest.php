<?php

namespace Tests\Definitions;

use Tests\Definitions\Blueprint\BlueprintBigInteger;
use Tests\Definitions\Blueprint\BlueprintBoolean;
use Tests\Definitions\Blueprint\BlueprintChar;
use Tests\Definitions\Blueprint\BlueprintDate;
use Tests\Definitions\Blueprint\BlueprintDateTime;
use Tests\Definitions\Blueprint\BlueprintDecimal;
use Tests\Definitions\Blueprint\BlueprintDouble;
use Tests\Definitions\Blueprint\BlueprintFloat;
use Tests\Definitions\Blueprint\BlueprintInteger;
use Tests\Definitions\Blueprint\BlueprintRememberToken;
use Tests\Definitions\Blueprint\BlueprintSmallInteger;
use Tests\Definitions\Blueprint\BlueprintString;
use Tests\Definitions\Blueprint\BlueprintText;
use Tests\Definitions\Blueprint\BlueprintTime;
use Tests\Definitions\Tables\TableWithOneColumn;
use Tests\Definitions\Tables\TableWithCommonColumns;
use Tests\Definitions\Tables\TableWithCompositeForeignKey;
use Tests\Definitions\Tables\TableWithCompositePrimaryKey;
use Tests\Definitions\Tables\TableWithDefaultValueForColumn;
use Tests\Definitions\Tables\TableWithIndexColumn;
use Tests\Definitions\Tables\TableWithNullableColumn;
use Tests\Definitions\Tables\TableWithSingleForeignKey;
use Tests\Definitions\Tables\TableWithSinglePrimaryKey;
use Tests\Definitions\Tables\TableWithUniqueColumn;
use Tests\SchemaDefinitionRunner;
use Tests\TestCase;

class SchemaDefinitionTest extends TestCase
{
    use SchemaDefinitionRunner;

    /**
     * @see TableWithOneColumn
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testWithOneColumn()
    {
        $this->runSchemaDefinitionTestFor(
            new TableWithOneColumn()
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
     * @see TableWithCompositeForeignKey
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testWithCompositeForeignKey()
    {
        $this->runSchemaDefinitionTestFor(
            new TableWithCompositeForeignKey()
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

    /**
     * @see BlueprintBigInteger
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testBlueprintBigInteger()
    {
        $this->runSchemaDefinitionTestFor(
            new BlueprintBigInteger()
        );
    }

    /**
     * @see BlueprintSmallInteger
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testBlueprintSmallInteger()
    {
        $this->runSchemaDefinitionTestFor(
            new BlueprintSmallInteger()
        );
    }

    /**
     * @see BlueprintRememberToken
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testBlueprintRememberToken()
    {
        $this->runSchemaDefinitionTestFor(
            new BlueprintRememberToken()
        );
    }
}
