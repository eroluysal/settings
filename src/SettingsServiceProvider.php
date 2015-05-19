<?php namespace QweB\Settings;

use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider {

	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->mergeConfigFrom(__DIR__.'/config/settings.php', 'settings');

		$this->publishes(
			[__DIR__.'/migrations' => database_path('/migrations')], 'migrations'
		);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerItemRepository();

		$this->registerSettingsProvider();
	}

	/**
	 * Register the settings provider.
	 *
	 * @return void
	 */
	protected function registerSettingsProvider()
	{
		$this->app->bind('settings', function($app)
		{
			$settings = $app['settings.item'];

			$cache = $app['cache']->driver();

			return new Settings($settings, $cache);
		});
	}

	/**
	 * Register the item repository.
	 *
	 * @return void
	 */
	protected function registerItemRepository()
	{
		$this->app->bind('settings.item', function($app)
		{
			$connection = $app['db']->connection();

			$table = $app['config']['settings.table'];

			return new DatabaseSettingsRepository($connection, $table);
		});
	}

}
