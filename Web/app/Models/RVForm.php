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
use Admin\Models\PaymentType;
use Admin\Models\PaymentCategory;
use Admin\Models\Currencies;
use Admin\Models\Branches;
use Admin\Models\RVInvoiceImages;

class RVForm extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rv_form_details';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
            'rv_form_number',
            'rv_created_date',
            'customer_name',
            'customer_contact_number',
            'customer_code',
            'amount', 
            'payment_type_id', 
            'cheque_numbers', 
            'bank_details', 
            'comments', 
            'currency_id', 
            'branch_id', 
            'pament_category_id',
            'collector_mobile_number',
            'collector_name',
            'collector_email',
            'collector_id',
    ];



    /**
     * Function to alter the invoice image attribute
     *
     * @param string $value
     * @return string
     */
    public function getRvFormImageAttribute($rvFormImage)
    {
        $prefixUrl = url('/').'/files/';
            return $prefixUrl.$rvFormImage;
    }

    /**
     * HasOne relationship
     */
    public function rvInvoice()
    {
        return $this->hasMany(RVInvoiceImages::class, 'rv_form_number', 'rv_form_number')->select(['id','rv_form_number','invoice_number','invoice_image','invoice_division']);
    }

    /**
     * Function to alter the RV date attribute
     *
     * @param string $value
     * @return string
     */
    public function getRvCreatedDateAttribute($rvCreatedDate)
    {
        return date("d-m-Y", strtotime($rvCreatedDate));

    }
    /**
     * HasOne relationship
     */
    public function paymentType()
    {
        return $this->hasOne(PaymentType::class, 'id', 'payment_type_id')->select(['id','payment_name']);
    }
        /**
     * HasOne relationship
     */
    public function paymentCategory()
    {
        return $this->hasOne(PaymentCategory::class, 'id', 'pament_category_id')->select(['id','category_name']);
    }
        /**
     * HasOne relationship
     */
    public function currencies()
    {
        return $this->hasOne(Currencies::class, 'id', 'currency_id')->select(['id','currency_name']);
    }
        /**
     * HasOne relationship
     */
    public function branches()
    {
        return $this->hasOne(Branches::class, 'id', 'branch_id')->select(['id','branch_name']);
    }
}
