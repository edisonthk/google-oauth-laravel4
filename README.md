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

After finish installed, import service provider and alias in app/config/app.php

```php
'providers' => array(
	'Edisonthk\GoogleOAuth\GoogleOAuthServiceProvider',
)

 :
 :

'aliases' => array(
	'GoogleOAuth'	=> 'Edisonthk\GoogleOAuth\Facade\GoogleOAuth',
)

```

# Configuration & Credentials
Get your client_secret and client_id from Google Developers Console. Then, configure it with laravel. There are 2 options you can configure with it.

### Option 1:
Create config file by artisan command.

```
$ php artisan config:publish edisonthk/google-oauth-laravel4
```

Then, config file will be generated at app/config/packages/edisonthk/google-oauth-laravel4/config.php. Fill it in with your client_secret, cliend_id, redirect_url and scope.


### Option 2:
Create a config file called google-oauth-laravel4.php in app/config directory. Then add following code and fill in your client_secret, cliend_id and redirect_url.

```php
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
		 * Google
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

# Sample code

On configuration

```
'Google' => array(
    'client_id'     => 'Your Google client ID',
    'client_secret' => 'Your Google Client Secret',
    'redirect_url' 	=> 'http://www.example.com/success'
    'scope'         => array('userinfo_email', 'userinfo_profile'),
),
```

On app/routes.php

```
Route::controller('/', 'HomeController');
```

On app/controllers/HomeController.php
```
<?php

class HomeController extends BaseController {

	public function getIndex()
	{
		$authUrl = GoogleOAuth::getAuthorizationUri();
		$message = "<a href='$authUrl'>Login with Google</a>";

		die($message);
	}

	public function getSuccess()
	{
		$googleService = GoogleOAuth::consumer();

		if(Input::has("code")){
			$code = Input::get("code");
			$googleService->requestAccessToken($code);
			return Redirect::to("/success");
		}

		if(!GoogleOAuth::hasAuthorized()){
			die("Not authorized yet");
		}

        
        $result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );

        $message = 'Your unique Google user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
        die($message. "<br/>");


	}

	public function getLogout()
	{
		GoogleOAuth::logout();
		return Redirect::to("/");
	}


}

```