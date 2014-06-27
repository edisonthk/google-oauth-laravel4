<?php
/**
 * @author     Heng LikWee <edisonthk@gmail.com>
 * @copyright  Copyright (c) 2013
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */

namespace Edisonthk\GoogleOAuth;

use OAuth\Common\Storage\Session;
use OAuth\Common\Token\Exception\ExpiredTokenException;
use OAuth\Common\Token\TokenInterface;
use OAuth\Common\Storage\Exception\TokenNotFoundException; 

class GoogleOAuth extends OAuth
{

	const _SERVICE = "Google";

	public function consumer($service = self::_SERVICE, $url = NULL, $scope = NULL)
	{
		return parent::consumer($service , $url, $scope);
	}

	public function getAuthorizationUri($parameter = array())
	{
		$googleService = $this->consumer();

		if(!empty($this->_access_type)){

			$parameter["access_type"] = $this->_access_type;

			return $googleService->getAuthorizationUri($parameter);
		}
		
		return $googleService->getAuthorizationUri($parameter);
	}

	public function logout()
	{
		$storage = new Session();
		$storage->clearAllTokens();
		$storage->clearAllAuthorizationStates();
	}


	public function hasAuthorized()
	{
		return $this->hasAccessToken() && !$this->isAccessTokenExpired();
	}

	public function hasAccessToken()
	{
		$storage = new Session();

		return $storage->hasAccessToken(self::_SERVICE);
	}

	public function isAccessTokenExpired()
	{
		$storage = new Session();
		try{

			$token = $storage->retrieveAccessToken(self::_SERVICE);

			if(is_null($token)){
				return true;
			}

			return ($token->getEndOfLife() !== TokenInterface::EOL_NEVER_EXPIRES
	            && $token->getEndOfLife() !== TokenInterface::EOL_UNKNOWN
	            && time() > $token->getEndOfLife()
	        );

		}catch(TokenNotFoundException $e){
			return true;
		}catch(ExpiredTokenException $e){
			return true;
		}

		return false;
		
	}

}