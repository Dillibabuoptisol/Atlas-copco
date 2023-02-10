<?php
/**
 * AdminApiController
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

use Admin\Repositories\AdminRepository as AdminBaseRepository;
use Admin\Repositories\Web\AdminRepository ;
use Contus\Base\Controllers\Api\ApiController;

class AdminApiController extends ApiController {
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct() {
    parent::__construct ();

    if ($this->isMobileRequest()) {
      $this->repository = new AdminBaseRepository();
    }else{
      $this->repository = new AdminRepository();
    }
  }
}
