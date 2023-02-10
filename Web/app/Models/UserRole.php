<?php
/**
 * User Role
 *
 * This model will going to hold the table related to user roles  and its relations
 *
 * @category  Contus
 * @package   Contus_laravel 5.3
 * @author    Contus Team <developers@contus.in>
 * @copyright Copyright (C) 2018 Contus. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 **/
namespace Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Contus\Base\Traits\QueryScopeHandler;

class UserRole extends Model {
    use QueryScopeHandler;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_roles';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
            'name' 
    ];
}
