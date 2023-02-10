<?php
/**
 * Email Template Repository 
 *
 * To manage email template related actions.
 *
 * @name       EmailTemplateRepository
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Repositories;

use Admin\Models\EmailTemplate;
use Contus\Base\Repositories\Repository;

class EmailTemplateRepository extends Repository {
    /**
     * Class initializer
     *
     * @return void
     */
    public function __construct(EmailTemplate $emailTemplate) {
        parent::__construct ();
        $this->emailTemplate = $emailTemplate;
    }
    /**
     * This method is use to save the data in email templates tables
     *
     * @see \\Contus\Base\Contracts\ResourceInterface::store()
     *
     * @return boolean
     */
    public function store() {
        return $this->addOrUpdate ( $this->request->all () );
    }
    
    /**
     * This method is use to update the email templates
     *
     * @see \Contus\Base\Contracts\ResourceInterface::update()
     * @return boolean
     */
    public function update() {
        return $this->addOrUpdate ( $this->request->all (), $this->request->id );
    }
    
    /**
     * This method is use as a common method for both store and update email templates
     *
     * @param array $requestData            
     * @param int $id            
     * @return boolean
     */
    public function addOrUpdate($requestData, $id = null) {
        $operationStatus = true;
        if (! empty ( $id )) {
            $emailTemplate = $this->emailTemplate->find ( $id );
            $this->setRule ( 'name', 'required|unique:email_templates,name,' . $emailTemplate->id . '|max:50' );
        } else {
            $emailTemplate = $this->emailTemplate;
            $this->setRule ( 'name', 'required|unique:email_templates,name|max:50' );
        }
        $this->setRule ( 'is_active', 'required|numeric' );
        $this->setRule ( 'subject', 'required' );
        $this->_validate ();
        $emailTemplate->fill ( $this->request->all () );
        $emailTemplate->fill ( array (
                'creator_id' => $this->request->user_id,
                'updator_id' => $this->request->user_id 
        ) );
        if (empty ( $id )) {
            $emailTemplate->slug = str_slug ( $this->request->name );
        }
        $emailTemplate->save ();
        return $operationStatus;
    }
    /**
     * Prepare the grid
     * set the grid model and relation model to be loaded
     *
     * @return \Contus\Base\Repositories\Repository
     */
    public function prepareGrid() {
        $this->setGridModel ( $this->emailTemplate );
        return $this;
    }
    
    /**
     * Update grid records collection query
     *
     * @param mixed $emailTemplate            
     * @return mixed
     */
    protected function updateGridQuery($emailTemplate) {
        /**
         * updated the grid query by using this function and apply the is_active condition.
         */
        $filters = $this->request->input ( 'filters' );
        if (! empty ( $filters )) {
            $emailTemplate = $this->updateData($filters,$emailTemplate);
        }
        return $emailTemplate;
    }
    
    
    public function updateData($filters,$emailTemplate) {
        foreach ( $filters as $key => $value ) {
            switch ($key) {
                case 'name' :
                    $emailTemplate->where ( 'name', 'like', '%' . $value . '%' )->get ();
                    break;
                case 'description' :
                    $emailTemplate->where ( 'description', 'like', '%' . $value . '%' )->get ();
                    break;
                default :
                    $emailTemplate->where ( 'is_active', 1 )->orWhere ( 'is_active', 0 );
                    break;
            }
        }
        return $emailTemplate;
    }
    
    /**
     * This method is use to soft delete the records
     *
     * @see \Contus\Base\Contracts\ResourceInterface::destroy()
     *
     * @return bool
     */
    public function destroy() {
        return $this->emailTemplate->where ( 'id', $this->request->id )->update ( array (
                'is_active' => 0 
        ) );
    }
    /**
     * Method to get the data of single record of email template
     *
     * @see \Contus\Base\Contracts\ResourceInterface::edit()
     * @return array, id, list of email
     */
    public function edit($id) {
        return array (
                'id' => $id,
                'emailSingleInfo' => $this->emailTemplate->where ( 'id', $id )->first (),
                'rules' => array (
                        'name' => 'required',
                        'subject' => 'required',
                        'body' => 'required' 
                ) 
        );
    }
    /**
     * Method to get the rules of email template
     *
     * @see \Contus\Base\Contracts\ResourceInterface::create()
     * @return array
     */
    public function create() {
        return array (
                'rules' => array (
                        'name' => 'required',
                        'subject' => 'required',
                        'body' => 'required' 
                ) 
        );
    }
}
