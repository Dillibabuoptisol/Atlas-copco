<?php
/**
 * Contain the common query scope method used by the Eloquent Model
 *
 * @name       QueryScopeHandler
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Base\Traits;

trait QueryScopeHandler {
  /**
   * Scope a query for like field.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param string $field
   * @param string $likeValue
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeLike($query,$field,$likeValue){
    return $query->where($field,'like',"%$likeValue%");
  }
  /**
   * Scope a query for where condition.
   *
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param string $field
   * @param string $value
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeAnd($query,$field,$value){
    return $query->where($field,$value);
  }  
}