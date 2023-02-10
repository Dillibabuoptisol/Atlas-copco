<?php
/**
 * EmailTemplateApiController
 *
 * To email template related activities
 *
 * @name       EmailTemplateApiController
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Http\Controllers\Api;

use Admin\Repositories\EmailTemplateRepository;
use Contus\Base\Controllers\Api\ApiController;

class EmailTemplateApiController extends ApiController {
    
    /**
     * Class initializer
     *
     * @param EmailTemplateRepository $emailTemplateRepository            
     */
    public function __construct(EmailTemplateRepository $emailTemplateRepository) {
        parent::__construct ();
        $this->repository = $emailTemplateRepository;
    }
}