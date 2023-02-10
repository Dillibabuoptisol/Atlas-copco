<?php
/**
 * Admin Users
 *
 * This model will going to hold the table related to admin users and its relations
 * Contians the common validations used by this model
 *
 * @category  Contus
 * @package   Contus_laravel 5.3
 * @author    Contus Team <developers@contus.in>
 * @copyright Copyright (C) 2018 Contus. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @version   Release: 1.0
 */
namespace Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Admin\Models\UserRole;

class AdminUser extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admin_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
            'name',
            'mobile_number',
            'email',
            'is_active',
            'access_token',
            'creator_id',
            'updator_id' 
    ];

        /**
     * Function to alter the invoice image attribute
     *
     * @param string $value
     * @return string
     */
    public function getCreatedAtAttribute($createAt)
    {
        return  date("d-m-Y", strtotime($createAt));
    }
}