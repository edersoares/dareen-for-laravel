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
     * Return expected content.
     *
     * @return string
     */
    public function expected()
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
            $table->increments(\'id\');
            $table->string(\'name\');
            $table->string(\'email\');
            $table->timestamp(\'email_verified_at\')->nullable();
            $table->string(\'password\');
            $table->rememberToken();
            $table->timestamps();
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
