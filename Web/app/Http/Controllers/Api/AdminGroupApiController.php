<?php

/**
 * AdminGroupApiController
 *
 * To manage admin user related activities
 *
 * @name       AdminApiController
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Http\Controllers\Api;

use Admin\Repositories\AdminGroupRepository;
use Contus\Base\Controllers\Api\ApiController;

class AdminGroupApiController extends ApiController {
/**
 * Create a new controller instance.
 *
 * @return void
 */
public function __construct(AdminGroupRepository $adminGroupRepository) {
 parent::__construct ();
 $this->repository = $adminGroupRepository;
}
}
