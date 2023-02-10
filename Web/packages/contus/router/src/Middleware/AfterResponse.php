<?php
/**
 * AfterResponse Middleware
 *
 * @name       AfterResponse
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Router\Middleware;

use Closure;
use Contus\Router\Models\RouterLog;

class AfterResponse{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        return $next($request);
    }
    /**
     * Terminate.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return mixed
     */
    public function terminate(){
        app('contus.router.logger')->logToModel();
    }    
}
