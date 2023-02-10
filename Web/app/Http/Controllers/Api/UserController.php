<?php
/**
 * UserController
 *
 * To manage user controller
 *
 * @name       UserController
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Http\Controllers\Api;

use Admin\Repositories\UserRepository;
use Contus\Base\Controllers\Api\ApiController;

class UserController extends ApiController {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository) {
        parent::__construct ();
        $this->repository = $userRepository;
    }
}
