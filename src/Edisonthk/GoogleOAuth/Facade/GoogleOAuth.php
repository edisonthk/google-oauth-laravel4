<?php 
/**
 * @author     Heng LikWee <edisonthk@gmail.com>
 * @copyright  Copyright (c) 2013
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */

namespace Edisonthk\GoogleOAuth\Facade;

use Illuminate\Support\Facades\Facade;

class GoogleOAuth extends Facade 
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'google-oauth'; }

}