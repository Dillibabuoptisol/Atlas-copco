<?php
/**
 * Admin Grid Interface
 *
 * To manage grid section for admin website management.
 *
 * @name       GridableInterface
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Base\Contracts;

interface GridableInterface {
  /**
   * Prepare the grid
   * set the grid model and relation model to be loaded
   *
   * @return \Admin\Repositories\BaseRepository
   */
  public function prepareGrid();    
  /**
   * Function used to retrieve records with field sorting(asc/desc) from database
   * 
   * @return object records
   */
  public function getRecords();
  /**
   * Act as manager for vaious action performed in the grid
   *
   * @return boolean
   */
  public function action();
  /**
   * Get additional information for grid
   * helper method helps to append more information to grid
   *
   * @return array
   */
  public function getGridAdditionalInformation();
  /**
   * Get Formatted grid response
   *
   * @param mixed $collection            
   * @return array
   */
  public function getFormattedGridCollection($collection);  
}