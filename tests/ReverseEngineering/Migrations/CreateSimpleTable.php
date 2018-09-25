<?php

namespace Tests\ReverseEngineering\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Tests\Migration;

class CreateSimpleTable extends Migration
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('simple', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name');
            $table->primary('id');
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('simple');
    }

    /**
     * Return the expected migration file content.
     *
     * @return string
     */
    public function expected()
    {
        return '<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

class CreateSimpleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(\'simple\', function (Blueprint $table) {
            $table->integer(\'id\');
            $table->string(\'name\');
            $table->primary(\'id\');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(\'simple\');
    }
}
';
    }
}
