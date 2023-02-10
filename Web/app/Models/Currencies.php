<?php
/**
 * CurrencyOptions
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

class Currencies extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'currencies';
    
}