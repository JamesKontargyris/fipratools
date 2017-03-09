<?php namespace Leadofficelist\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Leadofficelist\Sector_categories\Sector_category;

// Helps avoid a hacky way around setting the model name when a sector category is filtered
class SectorCategoryServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// Register 'SectorCategory' instance container to our SectorCategory object
		$this->app['SectorCategory'] = $this->app->share(function($app)
		{
			return new Sector_category;
		});
	}
}