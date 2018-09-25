<?php

namespace Tests\ReverseEngineering\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Tests\Migration;

class CreateUsersTable extends Migration
{
    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->builder->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->builder->dropIfExists('users');
    }

    /**
     * Return the expected migration file content.
     *
     * @return string
     */
    public function expected()
    {
        if ($this->builder->getConnection()->getDriverName() === 'sqlite') {
            return $this->expectedForSqlite();
        }

        return '<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(\'users\', function (Blueprint $table) {
            $table->integer(\'id\', true);
            $table->string(\'name\');
            $table->string(\'email\');
            $table->dateTime(\'email_verified_at\')->nullable();
            $table->string(\'password\');
            $table->string(\'remember_token\', 100)->nullable();
            $table->dateTime(\'created_at\')->nullable();
            $table->dateTime(\'updated_at\')->nullable();
            $table->primary(\'id\');
            $table->unique(\'email\');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(\'users\');
    }
}
';
    }

    /**
     * @return string
     */
    public function expectedForSqlite()
    {

        return '<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(\'users\', function (Blueprint $table) {
            $table->integer(\'id\', true);
            $table->string(\'name\');
            $table->string(\'email\');
            $table->dateTime(\'email_verified_at\')->nullable();
            $table->string(\'password\');
            $table->string(\'remember_token\')->nullable();
            $table->dateTime(\'created_at\')->nullable();
            $table->dateTime(\'updated_at\')->nullable();
            $table->primary(\'id\');
            $table->unique(\'email\');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(\'users\');
    }
}
';
    }
}
