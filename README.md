# Google OAuth for Laravel 4

oauth-4-laravel is a simple laravel 4 Google OAuth 2.0 . It is integrated with [Lusitanian/PHPoAuthLib](https://github.com/Lusitanian/PHPoAuthLib) and [artdarek/oauth-4-laravel](https://github.com/artdarek/oauth-4-laravel)
which provides oAuth 2.0 support in PHP 5.3+ for laravel 4.

---
 
# Installation

This package is available in packagist.org. You can install it by adding following in composer.json

```
"require": {
    "edisonthk/google-oauth-laravel4": "dev-master"
},
```

then, install it by 

```
composer update
```


# Configuration & Credentials
Get your client_secret and client_id from Google Developers Console. Then, configure it with laravel. There are 2 options you can configure with it.

### Option 1:
Create config file by artisan command.

```
$ php artisan config:publish edisonthk/google-oauth
```

### Option 2:
Create a config file called google-oauth.php in app/config directory. Then add following code and fill in your client_secret, cliend_id and redirect_url.

```
<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Google' => array(
            'client_id'     => '',
            'client_secret' => '',
            'redirect_url'	=> '',
            'scope'         => array(),
        ),		

	)

);

```

