<?php
/**
 * CollectorApiController
 *
 * To email template related activities
 *
 * @name       CollectorApiController
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Http\Controllers\Api;

use Admin\Repositories\CollectorRepository;
use Contus\Base\Controllers\Api\ApiController;

class CollectorApiController extends ApiController {
    
    /**
     * Class initializer
     *
     * @param EmailTemplateRepository $collectorRepository            
     */
    public function __construct(CollectorRepository $collectorRepository) {
        parent::__construct ();
        $this->repository = $collectorRepository;
    }
}