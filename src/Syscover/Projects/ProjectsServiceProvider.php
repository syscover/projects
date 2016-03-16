<?php namespace Syscover\Projects;

use Illuminate\Support\ServiceProvider;

class ProjectsServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// include route.php file
		if (!$this->app->routesAreCached())
			require __DIR__ . '/../../routes.php';

		// register views
		$this->loadViewsFrom(__DIR__ . '/../../views', 'projects');

        // register translations
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'projects');

		// register config files
		$this->publishes([
			__DIR__ . '/../../config/projects.php' 				=> config_path('projects.php')
		]);

        // register migrations
        $this->publishes([
            __DIR__ . '/../../database/migrations/' 			=> base_path('/database/migrations'),
			__DIR__ . '/../../database/migrations/updates/' 	=> base_path('/database/migrations/updates'),
        ], 'migrations');

        // register migrations
        $this->publishes([
            __DIR__ . '/../../database/seeds/' 					=> base_path('/database/seeds')
        ], 'seeds');
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        //
	}
}