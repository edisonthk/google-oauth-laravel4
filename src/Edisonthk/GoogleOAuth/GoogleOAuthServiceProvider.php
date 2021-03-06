<?php 
/**
 * @author     Heng LikWee <edisonthk@gmail.com>
 * @copyright  Copyright (c) 2013
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */

namespace Edisonthk\GoogleOAuth;

use Illuminate\Support\ServiceProvider;

class GoogleOAuthServiceProvider extends ServiceProvider 
{

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
        $this->package('edisonthk/google-oauth-laravel4');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
	    // Register 'oauth'
		    $this->app['google-oauth'] = $this->app->share(function($app)
		    {
                // create oAuth instance
                	$oauth = new GoogleOAuth();
        		// return oAuth instance
		        	return $oauth;
		    });
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