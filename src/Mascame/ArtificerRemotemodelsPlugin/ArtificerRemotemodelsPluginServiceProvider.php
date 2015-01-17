<?php namespace Mascame\ArtificerRemotemodelsPlugin;

use Illuminate\Support\ServiceProvider;
use Mascame\Artificer\Plugin\PluginManager;

class ArtificerRemotemodelsPluginServiceProvider extends ServiceProvider {

	protected $package = 'mascame/artificer-remotemodels-plugin';
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package($this->package);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$package = $this->package;

		\App::bind($this->package, function () use ($package) {
			return new RemoteModelsPlugin($package);
		});

		new PluginManager($this->package);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
