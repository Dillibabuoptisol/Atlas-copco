<?php
/**
 * RoleApiController
 *
 * To manage admin roles api related activities
 *
 * @name       RoleApiController
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Http\Controllers\Api;

use Admin\Repositories\RoleRepository;
use Contus\Base\Controllers\Api\ApiController;

class RoleApiController extends ApiController {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RoleRepository $roleRepository) {
        parent::__construct ();
        $this->repository = $roleRepository;
    }
}
