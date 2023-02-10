<?php
/**
 * Route Manager
 *
 * @name       RouteManager
 * @package    Router
 * @version    1.0
 * @author     Contus<developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */

namespace Contus\Router;

use Illuminate\Support\Manager;
use Contus\Router\Drivers\Http;
use Contus\Router\Parser\JsonParser;

class RouteManager extends Manager{
    /**
     * Create an instance of HttpDriver driver.
     *
     * @return \Contus\Router\Drivers\Http
     */
    protected function createHttpDriver(){
        return new Http(new JsonParser,app('contus.router.logger'));
    }
    /**
     * Get the default router driver name.
     *
     * @return string
     */
    public function getDefaultDriver(){
        return 'http';
    }
}
