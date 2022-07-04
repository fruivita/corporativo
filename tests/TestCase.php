<?php

namespace FruiVita\Corporativo\Tests;

use FruiVita\Corporativo\CorporativoServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn ($modelName) => 'FruiVita\\Corporativo\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app): array
    {
        return [
            CorporativoServiceProvider::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getEnvironmentSetUp($app): void
    {
        Schema::dropAllTables();

        $arquivos = glob(__DIR__ . '/../database/migrations/*.php.stub');

        foreach ($arquivos as $arquivo) {
            $table = include $arquivo;

            $table->up();
        }
    }
}
