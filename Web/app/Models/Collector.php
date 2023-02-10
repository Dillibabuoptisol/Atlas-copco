<?php
/**
 * Collector
 *
 * This model will going to hold the table related to settings categories and its relations
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
use Illuminate\Foundation\Auth\User as Authenticatable;

class Collector extends Authenticatable {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'collector';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
        protected $fillable = [ 
            'name',
            'email',
            'password',
            'mobile_number',
            'collector_id',
            'is_active'
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