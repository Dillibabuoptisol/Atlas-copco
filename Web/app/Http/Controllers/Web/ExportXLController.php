<?php
/**
 * ExportController
 *
 * To manage Export related activities
 *
 * @name       ExportController
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Http\Controllers\Web;

use Admin\Repositories\RVFormRepository;

class ExportXLController extends WebController {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RVFormRepository $rVFormRepository) {
        parent::__construct ();
        $this->repository = $rVFormRepository;
    }

        /**
     * Function to get RV export 
     * it will return the RV export list 
     *
     * @return json object
     */
    public function downloadFile() {
        return $this->repository->downloadFile();
    }
}
