<?php
/**
 * ResourceInterface
 *
 * Provide structure for resource implemted Repository
 *
 * @name       ResourceInterface
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Base\Contracts;

interface ResourceInterface {
  /**
   * Prepare model creation dependent data
   *
   * @return array
   */
  public function create();
  /**
   * Return the model collection with pagination
   *
   * @return array
   */
  public function index();  
  /**
   * Create new model record
   *
   * @return boolean
   */
  public function store();
  /**
   * update the model record
   *
   * @return boolean
   */
  public function update(); 
  /**
   * destroy the model record
   *
   * @param int $id
   * @return boolean
   */
  public function destroy();  
  /**
   * handle bulk action request
   *
   * @return boolean
   */
  public function action();
}