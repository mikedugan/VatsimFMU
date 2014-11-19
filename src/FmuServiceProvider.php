<?php namespace Vatsim\Fmu;

use Illuminate\Support\ServiceProvider;

class FmuServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('vatsim/fmu');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['vatsimfmu'] = $this->app->share(function($app)
		{
			return new FMU( $app['config']->get('fmu::config') );
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array("vatsimfmu");
	}

}
