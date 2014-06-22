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
            'client_id'     => '87442276406-vbgl7vu7n6db1s8rcliu8fgf9mdln7jq.apps.googleusercontent.com',
            'client_secret' => 'NEK6U1St9bQuTGkflS6kFvq4',
            'redirect_url'	=> 'http://mytest1.no-ip.net/success/',
            'scope'         => array('userinfo_email', 'userinfo_profile'),
        ),		

	)

);