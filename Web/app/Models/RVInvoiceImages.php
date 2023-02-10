<?php
/**
 * RVForm
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


class RVInvoiceImages extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rv_invoice_images';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
            'rv_form_number',
            'invoice_number',
            'invoice_image'
    ];



    /**
     * Function to alter the invoice image attribute
     *
     * @param string $value
     * @return string
     */
    public function getInvoiceImageAttribute($invoiceImage)
    {
        if($invoiceImage){
        $prefixUrl = url('/').'/files/';
            return $prefixUrl.$invoiceImage;
        }else{
            return $invoiceImage;
        }
    }
}
