<?php
/**
 * @author     Heng LikWee <edisonthk@gmail.com>
 * @copyright  Copyright (c) 2013
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */

namespace Edisonthk\GoogleOAuth;

use OAuth\Common\Storage\Session;

class GoogleOAuth extends OAuth
{

	const _SERVICE = "Google";

	public function consumer($service = self::_SERVICE, $url = NULL, $scope = NULL)
	{
		return parent::consumer($service , $url, $scope);
	}

	public function getAuthorizationUri()
	{
		$googleService = $this->consumer();
		return $googleService->getAuthorizationUri();
	}

	public function logout()
	{
		$storage = new Session();
		$storage->clearAllTokens();
		$storage->clearAllAuthorizationStates();
	}

	public function hasAuthorized()
	{
		$storage = new Session();
		return $storage->hasAccessToken(self::_SERVICE);
	}

}