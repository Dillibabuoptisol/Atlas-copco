<?php
/**
 * Common resource CRUD container
 *
 * @name       ResourceHandler
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Base\Traits;

use Contus\Base\Contracts\GridableInterface;

trait ResourceHandler {
  /**
   * Prepare model creation dependent data
   *
   * @return array
   */
  public function create(){
      return [];
  }
  /**
   * Return the model collection with pagination
   *
   * @return array $data
   */
  public function index(){
      $data = [];      
      if ($this instanceof GridableInterface) {          
          $this->prepareGrid();
          $data[DATA] = $this->getRecords();                    
          if ($this->request->input(INTIALREQUEST) == 1){
              $data [MOREINFO] = $this->getGridAdditionalInformation();
          }
      }      
      return $data;
  }  
  /**
   * Create new model record
   *
   * @return boolean
   */
  public function store(){
      return []; 
  }
  /**
   * update the model record
   *
   * @return boolean
   */
  public function update(){
      return [];
  } 
  /**
   * destroy the model record
   *
   * @param int $id
   * @return boolean
   */
  public function destroy(){        
      return [];
  } 
  /**
   * Act as manager for vaious action performed in the grid
   *
   * @return boolean
   */
  public function action() {
      $response = false;      
      if(
          $this instanceof GridableInterface 
          && $this->request->has ( SELECTEDCHECKBOX ) 
          && is_array ( $this->request->get ( SELECTEDCHECKBOX ) )
      ) {
          $response = $this->prepareGrid()->gridDelete( $this->request->get ( SELECTEDCHECKBOX ));          
      }      
    
      return $response;
  }  
}