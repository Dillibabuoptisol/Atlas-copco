<?php
/**
 * RVFormApiController
 *
 * To email template related activities
 *
 * @name       RVFormApiController
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Http\Controllers\Api;

use Admin\Repositories\RVFormRepository;
use Contus\Base\Controllers\Api\ApiController;

class RVFormApiController extends ApiController {
    
    /**
     * Class initializer
     *
     * @param RVFormRepository $rVFormRepository            
     */
    public function __construct(RVFormRepository $rVFormRepository) {
        parent::__construct ();
        $this->repository = $rVFormRepository;
    }

     /**
     * Function to get RV List
     * it will takes the email and password as input and update the password and  returns the response
     *
     * @return json object
     */
    public function getRVlist() {
        return $this->repository->getRVlist();
    }

    /**
     * Function to get RV List
     * it will takes the email and password as input and update the password and  returns the response
     *
     * @return json object
     */
    public function addRVForm() {
        return $this->repository->addRVForm();
    }
    /**
     * Function to get RVDetail
     * it will takes the email and password as input and update the password and  returns the response
     *
     * @return json object
     */
    public function getRVDetail() {
        return $this->repository->getRVDetail();
    }
    /**
     * Function to delete RVRecord
     * it will takes the id and delete the rv record returns the response
     *
     * @return json object
     */
    public function deleteRVRecord($rVId) {
        return $this->repository->deleteRVRecord($rVId);
    }
    /**
     * Function to get RV Form Options
     * it will takes the email and password as input and update the password and  returns the response
     *
     * @return json object
     */
    public function getRVOptions() {
        return $this->repository->getRVOptions();
    }
    /**
     * Function to get RV Form Options
     * it will takes the email and password as input and update the password and  returns the response
     *
     * @return json object
     */
    public function rVSearch() {
        return $this->repository->rVSearch();
    }  

    /**
     * Function to get RV Images 
     * it will return the RV Images and  returns the response
     *
     * @return json object
     */
    public function rVImages($id) {
        return $this->repository->rVImages($id);
    } 
    /**
     * Function to Update RV Form 
     * it will return the RV Images and  returns the response
     *
     * @return json object
     */
    public function updateRV() {
        return $this->repository->updateRV();
    } 
    
}