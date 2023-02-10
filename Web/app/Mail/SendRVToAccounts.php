<?php

namespace Admin\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendRVToAccounts extends Mailable
{
    use Queueable, SerializesModels;


public $rVForm;
public $invoiceNumber;
public $currency;
public $pament_category;
public $payment_type;
public $division;
public $imagenames;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rVForm,$invoiceDetails,$currency,$payment_type,$branch,$pament_category){
    $this->rVForm =$rVForm;
    $this->invoiceDetails =$invoiceDetails;
    $this->currency =$currency;
    $this->pament_category =$pament_category;
    $this->payment_type =$payment_type;
    $this->branch =$branch;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build(){
      $formDetails = $this->rVForm->toArray();
      $invoiceNumbers = implode(', ', $this->invoiceDetails[0]);
      $invoiceDivisions = implode(', ', $this->invoiceDetails[2]);
      $formDetails['branch_name'] = $this->branch->branch_name;
      $formDetails['pament_category'] = $this->pament_category->category_name;
      $formDetails['payment_type'] = $this->payment_type->payment_name;
      $formDetails['currency'] =  $this->currency->currency_name;
      if (!$formDetails['cheque_numbers']) {
          $formDetails['cheque_numbers'] = '-';
      }
      if (!$formDetails['bank_details']) {
          $formDetails['bank_details'] = '-';
      }
         if (!$formDetails['comments']) {
          $formDetails['comments'] = '-';
      } 
      if (!$formDetails['customer_contact_number']) {
          $formDetails['customer_contact_number'] = '-';
      } 
     $email =  $this->from(env('MAIL_USERNAME'),'Atlas Copco')
      ->subject('RV Form Number'.'-'.$formDetails['rv_form_number'].' Submitted')
      ->view('email.rvaccountemail',[
                'RV_FORM_NUMBER' => $formDetails['rv_form_number'],
                'RV_DATE'=> $formDetails['rv_created_date'],
                'CUSTOMER_NAME'=> $formDetails['customer_name'],
                'CUSTOMER_CODE'=> $formDetails['customer_code'],
                'CUSTOMER_CONTACT_NUMBER' => $formDetails['customer_contact_number'],
                'INVOICE_NUMBERS' => $invoiceNumbers,
                'CURRENCY'=> $formDetails['currency'],
                'AMOUNT'=> $formDetails['amount'],
                'PAYMENT_CATEGORY' => $formDetails['pament_category'],
                'PAYMENT_TYPE' => $formDetails['payment_type'],
                'BRANCH' =>$formDetails['branch_name'],
                'DIVISION' => $invoiceDivisions,
                'CHEQUE_NUMBER'=> $formDetails['cheque_numbers'],
                'BANK_DETAILS' =>$formDetails['bank_details'],
                'COMMENTS' =>$formDetails['comments'],
                'COLLECTOR_ID' =>$formDetails['collector_id'],
                'COLLECTOR_NAME' =>$formDetails['collector_name'],
                'COLLECTOR_MOBILE_NUMBER' =>$formDetails['collector_mobile_number'],
                'COLLECTOR_EMAIL' =>$formDetails['collector_email']

    ]);
    foreach ($this->invoiceDetails[1] as $file) { 
        $email->attach(public_path().'/files/'.$file);
    }
        return $email;
}
}
