<?php
/**
 * SettingCategory
 *
 * This model will going to hold the table related to settings categories and its relations
 *
 * @category  Contus
 * @package   Contus_laravel 5.2
 * @author    Contus Team <developers@contus.in>
 * @copyright Copyright (C) 2018 Contus. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @version   Release: 1.0
 */
namespace Admin\Models;

use Illuminate\Database\Eloquent\Model;

class SettingCategory extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'setting_categories';
    
    /**
     * Method used to retrive the settings with hasMany relation.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function settings() {
        return $this->hasMany ( Setting::class );
    }
    
    /**
     * Method used to retrive the setting category with hasMany relation.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function category() {
        return $this->hasMany ( SettingCategory::class, 'parent_id' );
    }
}