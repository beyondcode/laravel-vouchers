<?php

namespace BeyondCode\Vouchers\Tests;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Schema\Blueprint;
use BeyondCode\Vouchers\Facades\Vouchers;
use BeyondCode\Vouchers\VouchersServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{

    public function setUp()
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'sqlite']);

        $this->setUpDatabase();

        $this->createUser();
    }

    protected function getPackageProviders($app)
    {
        return [
            VouchersServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Vouchers' => Vouchers::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('vouchers.user_model', \BeyondCode\Vouchers\Tests\Models\User::class);

        $app['config']->set('database.default', 'sqlite');

        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('app.key', 'base64:6Cu/ozj4gPtIjmXjr8EdVnGFNsdRqZfHfVjQkmTlg4Y=');
    }

    protected function setUpDatabase()
    {
        include_once __DIR__.'/../database/migrations/create_vouchers_table.php.stub';
        (new \CreateVouchersTable())->up();

        $this->app['db']->connection()->getSchemaBuilder()->create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
    }

    protected function createUser()
    {
        User::forceCreate([
            'name' => 'User',
            'email' => 'user@email.com',
            'password' => 'test'
        ]);
    }


}