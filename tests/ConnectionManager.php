<?php

namespace Tests;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Connection;

trait ConnectionManager
{
    /**
     * Return the connection.
     *
     * @return Connection
     */
    protected function getConnection()
    {
        $manager = new Manager();

        $manager->addConnection(
            $this->getDatabaseConnectionConfig(env('DB_CONNECTION', 'sqlite'))
        );

        $connection = $manager->getConnection();

        $builder = $connection->getSchemaBuilder();
        $builder::defaultStringLength(191);

        return $manager->getConnection();
    }

    /**
     * Return the database connection configuration.
     *
     * @param string $name
     *
     * @return array
     */
    protected function getDatabaseConnectionConfig($name)
    {
        $configs = [

            'sqlite' => [
                'driver' => 'sqlite',
                'database' => env('DB_DATABASE', ':memory:'),
                'prefix' => '',
            ],

            'mysql' => [
                'driver' => 'mysql',
                'host' => env('DB_HOST', '127.0.0.1'),
                'port' => env('DB_PORT', '3306'),
                'database' => env('DB_DATABASE', 'dareen'),
                'username' => env('DB_USERNAME', 'dareen'),
                'password' => env('DB_PASSWORD', ''),
                'unix_socket' => env('DB_SOCKET', ''),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ],

            'pgsql' => [
                'driver' => 'pgsql',
                'host' => env('DB_HOST', '127.0.0.1'),
                'port' => env('DB_PORT', '5432'),
                'database' => env('DB_DATABASE', 'dareen'),
                'username' => env('DB_USERNAME', 'dareen'),
                'password' => env('DB_PASSWORD', ''),
                'charset' => 'utf8',
                'prefix' => '',
                'schema' => 'public',
                'sslmode' => 'prefer',
            ],

            'sqlsrv' => [
                'driver' => 'sqlsrv',
                'host' => env('DB_HOST', 'localhost'),
                'port' => env('DB_PORT', '1433'),
                'database' => env('DB_DATABASE', 'dareen'),
                'username' => env('DB_USERNAME', 'dareen'),
                'password' => env('DB_PASSWORD', ''),
                'charset' => 'utf8',
                'prefix' => '',
            ],
        ];

        return $configs[$name];
    }
}
