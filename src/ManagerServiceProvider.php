<?php

namespace Barryvdh\TranslationManager;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class ManagerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $configPath = __DIR__ . '/../config/translation-manager.php';
        $this->mergeConfigFrom($configPath, 'translation-manager');
        $this->publishes([$configPath => config_path('translation-manager.php')], 'config');

        $this->app->singleton('translation-manager', function ($app) {
            return $app->make(Manager::class);
        });

        $this->app->singleton('command.translation-manager.reset', function ($app) {
            return new Console\ResetCommand($app['translation-manager']);
        });
        $this->commands('command.translation-manager.reset');

        $this->app->singleton('command.translation-manager.import', function ($app) {
            return new Console\ImportCommand($app['translation-manager']);
        });
        $this->commands('command.translation-manager.import');

        $this->app->singleton('command.translation-manager.find', function ($app) {
            return new Console\FindCommand($app['translation-manager']);
        });
        $this->commands('command.translation-manager.find');

        $this->app->singleton('command.translation-manager.export', function ($app) {
            return new Console\ExportCommand($app['translation-manager']);
        });
        $this->commands('command.translation-manager.export');

        $this->app->singleton('command.translation-manager.clean', function ($app) {
            return new Console\CleanCommand($app['translation-manager']);
        });
        $this->commands('command.translation-manager.clean');
    }

    public function boot(Router $router): void
    {
        $viewPath = __DIR__ . '/../resources/views';
        $this->loadViewsFrom($viewPath, 'translation-manager');
        $this->publishes([
            $viewPath => base_path('resources/views/vendor/translation-manager'),
        ], 'views');

        $migrationPath = __DIR__ . '/../database/migrations';
        $this->publishes([
            $migrationPath => base_path('database/migrations'),
        ], 'migrations');

        $config              = $this->app['config']->get('translation-manager.route', []);
        $config['namespace'] = 'Barryvdh\TranslationManager';

        $router->group($config, function ($router) {
            $router->get('view/{group?}', 'Controller@getView')->where('group', '.*');
            $router->get('/{group?}', 'Controller@getIndex')->where('group', '.*');
            $router->post('/add/{group}', 'Controller@postAdd')->where('group', '.*');
            $router->post('/edit/{group}', 'Controller@postEdit')->where('group', '.*');
            $router->post('/delete/{group}/{key}', 'Controller@postDelete')->where('group', '.*');
            $router->post('/import', 'Controller@postImport');
            $router->post('/find', 'Controller@postFind');
            $router->post('/publish/{group}', 'Controller@postPublish')->where('group', '.*');

            $router->post('/service/usage', 'ServiceController@postUsage');
            $router->post('/service/{group}/bulk', 'ServiceController@postBulk')->where('group', '.*');
        });
    }

    public function provides(): array
    {
        return [
            'translation-manager',
            'command.translation-manager.reset',
            'command.translation-manager.import',
            'command.translation-manager.find',
            'command.translation-manager.export',
            'command.translation-manager.clean',
        ];
    }

}
