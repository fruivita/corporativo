<?php

namespace FruiVita\Corporativo;

use Illuminate\Support\ServiceProvider;

/**
 * @see https://laravel.com/docs/9.x/packages
 * @see https://laravel.com/docs/9.x/packages#service-providers
 * @see https://laravel.com/docs/9.x/providers
 */
class CorporativoServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'corporativo');

        $this->app->bind('corporativo', function ($app) {
            return new Corporativo();
        });
    }

    /**
     * @return void
     */
    public function boot()
    {
        $this->loadJsonTranslationsFrom(__DIR__ . '/../lang');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../lang' => lang_path('lang/vendor/corporativo'),
            ], 'lang');

            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('corporativo.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../database/migrations/create_cargos_table.php.stub' => database_path('migrations/2020_01_01_000000_create_cargos_table.php'),
                __DIR__ . '/../database/migrations/create_funcoes_confianca_table.php.stub' => database_path('migrations/2020_01_01_000000_create_funcoes_confianca_table.php'),
                __DIR__ . '/../database/migrations/create_lotacoes_table.php.stub' => database_path('migrations/2020_01_01_000000_create_lotacoes_table.php'),
                __DIR__ . '/../database/migrations/create_usuarios_table.php.stub' => database_path('migrations/2020_01_01_000000_create_usuarios_table.php'),
            ], 'migrations');
        }
    }
}
