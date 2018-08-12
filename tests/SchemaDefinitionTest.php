<?php

namespace Tests;

use Tests\Definitions\BasicTableWithOneColumn;
use Tests\Definitions\BlueprintDecimal;
use Tests\Definitions\BlueprintFloat;
use Tests\Definitions\BlueprintInteger;
use Tests\Definitions\BlueprintString;
use Tests\Definitions\TableWithCommonColumns;
use Tests\Definitions\TableWithDefaultValueForColumn;
use Tests\Definitions\TableWithNullableColumn;

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
     * @see BlueprintString()
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
}
