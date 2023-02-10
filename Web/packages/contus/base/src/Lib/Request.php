<?php
/**
 * Request
 *
 * @name       Request
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Base\Lib;

use Illuminate\Http\Request as IlluminateRequest; 

class Request extends IlluminateRequest{
    /**
     * Gets the scheme and HTTP host.
     *
     * If the URL was called with basic authentication, the user
     * and the password are not added to the generated string.
     * And made sure app uri environment variable appedended to the url
     * 
     * @return string The scheme and HTTP host
     */
    public function getSchemeAndHttpHost(){
        return $this->getScheme().'://'.$this->getHttpHost().(($appUri = env('APP_URI','')) ? "/$appUri" : '');
    }
}
