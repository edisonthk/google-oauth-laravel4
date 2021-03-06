<?php
/**
 * @author     Heng LikWee <edisonthk@gmail.com>
 * @copyright  Copyright (c) 2013
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */

namespace Edisonthk\GoogleOAuth;

use \Config;
use \URL;

use \OAuth\ServiceFactory;
use \OAuth\Common\Consumer\Credentials;

class OAuth
{
    /**
     * @var ServiceFactory
     */
    private $_serviceFactory;

    /**
     * Storege name from config
     * @var string
     */
    private $_storage_name = 'Session';

    /**
     * Client ID from config
     * @var string
     */
    private $_client_id;

    /**
     * Client secret from config
     * @var string
     */
    private $_client_secret;

    /**
     * Scope from config
     * @var array
     */
    private $_scope = array();

    private $_redirect_url;
    protected $_access_type;

    /**
     * Constructor
     *
     * @param ServiceFactory $serviceFactory - (Dependency injection) If not provided, a ServiceFactory instance will be constructed.
     */
    public function __construct(ServiceFactory $serviceFactory = null)
    {
        if (null === $serviceFactory) {
            // Create the service factory
            $serviceFactory = new ServiceFactory();
        }
        $this->_serviceFactory = $serviceFactory;

        $this->_redirect_url = URL::current();
    }

    /**
     * Detect config and set data from it
     *
     * @param string $service
     */
    public function setConfig( $service )
    {
        // if config/google-oauth.php exists use this one
        if ( Config::get('google-oauth-laravel4.consumers') != null ) {

            $this->_storage_name = Config::get('google-oauth-laravel4.storage', 'Session');
            $this->_client_id = Config::get("google-oauth-laravel4.consumers.$service.client_id");
            $this->_client_secret = Config::get("google-oauth-laravel4.consumers.$service.client_secret");
            $this->_scope = Config::get("google-oauth-laravel4.consumers.$service.scope", array() );
            $this->_redirect_url = Config::get("google-oauth-laravel4.consumers.$service.redirect_url");
            $this->_access_type = Config::get("google-oauth-laravel4.consumers.$service.access_type");

        // esle try to find config in packages configs
        } else {
            $this->_storage_name = Config::get('google-oauth-laravel4::storage', 'Session');
            $this->_client_id = Config::get("google-oauth-laravel4::consumers.$service.client_id");
            $this->_client_secret = Config::get("google-oauth-laravel4::consumers.$service.client_secret");
            $this->_scope = Config::get("google-oauth-laravel4::consumers.$service.scope", array() );
            $this->_redirect_url = Config::get("google-oauth-laravel4::consumers.$service.redirect_url");
            $this->_access_type = Config::get("google-oauth-laravel4::consumers.$service.access_type");
        }

    }

    /**
     * Create storage instance
     *
     * @param string $storageName
     * @return OAuth\Common\\Storage
     */
    public function createStorageInstance($storageName)
    {
        $storageClass = "\\OAuth\\Common\\Storage\\$storageName";
        $storage = new $storageClass();

        return $storage;
    }

    /**
     * Set the http client object
     *
     * @param string $httpClientName
     * @return void
     */
    public function setHttpClient($httpClientName)
    {
        $httpClientClass = "\\OAuth\\Common\\Http\\Client\\$httpClientName";
        $this->_serviceFactory->setHttpClient(new $httpClientClass());
    }

    /**
     * @param  string $service
     * @param  string $url
     * @param  array  $scope
     * @return \OAuth\Common\Service\AbstractService
     */
    public function consumer( $service, $url = null, $scope = null )
    {
        // get config
        $this->setConfig( $service );

        // get storage object
        $storage = $this->createStorageInstance( $this->_storage_name );

        // create credentials object
        $credentials = new Credentials(
            $this->_client_id,
            $this->_client_secret,
            $this->_redirect_url
        );

        // check if scopes were provided
        if (is_null($scope))
        {
            // get scope from config (default to empty array)
            $scope = $this->_scope;
        }

        // return the service consumer object
        return $this->_serviceFactory->createService($service, $credentials, $storage, $scope);

    }

}
