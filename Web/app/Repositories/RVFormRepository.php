<?php
/**
 * Email Template Repository 
 *
 * To manage email template related actions.
 *
 * @name       RVFormRepository
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Repositories;

use Admin\Models\RVForm;
use Admin\Models\RVInvoiceImages;
use Contus\Base\Repositories\Repository;
use Illuminate\Auth\Access\Response;
use Admin\Models\Currencies;
use Admin\Models\PaymentCategory;
use Admin\Models\PaymentType;
use Admin\Models\Branches;
use Admin\Models\EmailTemplate;
use Admin\Models\Setting;
use Admin\Models\Collector;
use Admin\Mail\SendRVToAccounts;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
class RVFormRepository extends Repository {
    /**
     * Class initializer
     *
     * @return void
     */
    public function __construct(RVForm $rVForm, RVInvoiceImages $rVInvoiceImages,Currencies $currencies,PaymentCategory $paymentCategory,PaymentType $paymentType,Branches $branches,Setting $setting) {
        parent::__construct ();
        $this->rVForm = $rVForm;
        $this->rVInvoiceImages = $rVInvoiceImages;
        $this->branches = $branches;
        $this->paymentType = $paymentType;
        $this->paymentCategory = $paymentCategory;
        $this->currencies = $currencies;
        $this->setting = $setting;
    }
    /**
     * This method is use to save the data in email templates tables
     *
     * @see \\Contus\Base\Contracts\ResourceInterface::store()
     *
     * @return boolean
     */
    public function store() {
        return $this->addOrUpdate ( $this->request->all () );
    }
    

       /**
     * This method is use to soft delete the records
     *
     * @see \Contus\Base\Contracts\ResourceInterface::destroy()
     *
     * @return bool
     */
    public function deleteRVRecord($rVId) {
        $adminUser = Auth::user()->name;
        $rvID = $this->rVForm->where('id',$rVId)->first();
        $rvimages = $this->rVForm->where('id',$rVId)->first();
        if ($rvID && $rvimages) {
            $this->rVForm->where('id', $rVId)->delete();
            $this->rVInvoiceImages->where('rv_form_number', $rvID)->delete();
            return $this->prepareEmailContent($adminUser,$rvID->rv_form_number);
        }else{
            return false;
        }
    }

       /**
     * This method is use to  delete the records
     *
     * @see \Contus\Base\Contracts\ResourceInterface::destroy()
     *
     * @return bool
     */
    public function updateRV() {
        $editBy = Auth::user()->name;
        $isUpdated = $this->rVForm->where('rv_form_number', '=', $this->request->rv_form_number)->update(['transaction_date' => $this->request->transaction_date,'transaction_number' =>$this->request->transaction_number,'edit_by' => $editBy]);
        if ($isUpdated) {
           return $this->getSuccessJsonResponse([], 'RV form sucessfully updated', 200);
        }else{
            return $this->getSuccessJsonResponse([], 'RV form not updated', 200);
        }
        

        
    }
    /**
     * Get the Prepare Email template contents
     * 
     * @param string $slug            
     * @return array
     */
   
    public function prepareEmailContent($name,$rvnumber){
        $this->emailTemplate = new EmailTemplate ();
       $templateData = $this->emailTemplate->where ( 'slug', 'receipt_voucher_delete' )->get ()->toArray ();
       $rvDeleteTemplate = array_shift ( $templateData );
            if (isset ( $rvDeleteTemplate )) {
                $logoImage = url('/').'/assets/images/Atlaslogo.png';
                $logolink = url('/');
                $subject = $rvDeleteTemplate ['subject'];
                $emailContent = $rvDeleteTemplate ['body'];  
                $emailContent = str_replace ( array (
                        '{{LOGO}}',
                        '{{LOGOURL}}',
                        '{{RV_NUMBER}}',
                        '{{ADMIN_USER}}',
                ), array (
                        $logoImage,
                        $logolink,
                        $rvnumber,
                        $name
                ), $emailContent );
                return $this->sendEmail( $emailContent, $subject );

            } else {
                return $this->getErrorJsonResponse([], 'Email data is not available', 422);
            }
    }


    /**
     * Function to send the email notification
     *
     * @return array
     */
    public function sendEmail($emailContent, $subject) {
        $fromEmail = env('MAIL_USERNAME');
        $accountsEmail= $this->setting->where('setting_name','accounts_team_email_address')->select('setting_value')->first();
        $accountsEmails = explode(",",$accountsEmail->setting_value);
        $response = '';
        try {
            foreach ($accountsEmails as $email) {              
            $response = app ( 'mailer' )->send ( [ ], [ ], function ($message) use ($fromEmail, $email, $subject, $emailContent) {
            $message->to ( $email )->from ( $fromEmail, 'Atlas Copco' )->subject ( $subject )->setBody ( $emailContent, 'text/html' );
        } ); 
        }
        } catch (Exception $e) {
           $response = $e;            
        }
        if ($response===NULL) {
            return $this->getSuccessJsonResponse([], 'Receipt Voucher sucessfully deleted', 200);
        }else{
             return $this->getErrorJsonResponse([], 'Receipt Voucher not deleted', 422);
        }

}
    /**
     * This method is use to update the email templates
     *
     * @see \Contus\Base\Contracts\ResourceInterface::update()
     * @return boolean
     */
    public function update() {
        return $this->addOrUpdate ( $this->request->all (), $this->request->id );
    }
    /**
     * This method is use to update the email templates
     *
     * @see \Contus\Base\Contracts\ResourceInterface::update()
     * @return boolean
     */
    public function rVImages($id) {
        return $this->rVInvoiceImages->where ( 'rv_form_number',$id )->get();
    }
    
  /**
   * Prepare the grid
   * set the grid model and relation model to be loaded
   *
   * @return \Contus\Base\Repositories\Repository
   */
  public function prepareGrid() {
   $this->setGridModel ( $this->rVForm )->setEagerLoadingModels (['paymentType','currencies']);
    return $this;
  }


  /**
   * Method to pass additional information to the grid
   *
   * @see \Contus\Base\Contracts\GridableInterface::getGridAdditionalInformation()
   */
  public function getGridAdditionalInformation() {
     return 
     [
        'payment_type' => $this->paymentType->where ( 'is_active', 1 )->get(),
        'currency_type' => $this->currencies->where ( 'is_active', 1 )->get()
     ];
  }


      /**
     * Method to get the data of single record of collector template
     *
     * @see \Contus\Base\Contracts\ResourceInterface::edit()
     * @return array, id, list of email
     */
    public function edit($id) {
        $result = (new RVForm())->with(['paymentType','paymentCategory','currencies','branches','rvInvoice'])->find($id)->toArray();
            $divisionName='';
            $invoiceDetails=$result['rv_invoice'];
                   foreach ($invoiceDetails as $count => $value) {
                    $division= $invoiceDetails[$count]['invoice_number'].'('.$invoiceDetails[$count]['invoice_division'].')';
                    $divisionName = $divisionName.$division.',';

                    
                   }
                   $result['rv_division'] =$divisionName;
        return [ 'rvDetails' => $result];
    }
    /**
   * Update grid records collection query
   *
   * @param mixed $builder          
   * @return mixed
   */
  protected function updateGridQuery($rVForm) {
    /**
     * updated the grid query by using this function and apply the video condition.
     */
    $filters = $this->request->input('filters');
    $filterKeys = ['rv_form_number','customer_code','customer_name','collector_id','collector_name','amount'];
    if (! empty ( $filters ) ) {
      foreach ( $filters as $key => $value ) {
        if (in_array($key, $filterKeys)) {
            $rVForm->where ( $key, 'like', '%' . $value . '%' )->get ();
        }else{
         $this->filters($rVForm,$key,$value);
        }
      }
    }
    return $rVForm;

  }
    /**
   * Update grid records collection query for relation models
   *
   * @param mixed $builder          
   * @return mixed
   */

  public function filters($rVForm,$key,$value ){

    switch ($key) {
            case 'status' :
              $rVForm->get();
            break;
            case 'payment_type' :
                if ($value == 'null') {
                  $rVForm->get();
                }else{
                    $rVForm->where ( 'payment_type_id', $value );
                }
                 break;
            case 'currency_type' :
                if ($value == 'null') {
                    $rVForm->get();
                }else{
                    $rVForm->where ( 'currency_id', $value );
                }
                break;
            case 'dateRange':
                $value = explode('-',trim($value));
                $rVForm->whereBetween('rv_created_date', [date("Y-m-d", strtotime($value[0])), date("Y-m-d", strtotime($value[1]))]);
                break;
            default :
                $rVForm->where ( $key, 'like', "%$value%" );
                break;
        }
  }
    /**
     * @SWG\Post(
     *      path="/api/v1/rvform",
     *      tags={"Add RV Form"},
     *      operationId="rvform",
     *      summary="Add RV Form API",
     *      @SWG\Parameter(
     *              name="x-request-type",
     *              in="header",
     *              required=true,
     *              type="string",
     *              default="mobile",
     *      ),
     *      @SWG\Parameter(
     *              name="token",
     *              in="header",
     *              required=true,
     *              type="string",
     *              default="",
     *      ),
     *      @SWG\Parameter(
     *              name="rv_form_number",
     *              in="formData",
     *              required=true,
     *              type="number",
     *              default="12345",
     *      ),
     *      @SWG\Parameter(
     *              name="rv_created_date",
     *              in="formData",
     *              required=true,
     *              type="string",
     *              default="2018-09-06",
     *      ),
     *      @SWG\Parameter(
     *              name="customer_name",
     *              in="formData",
     *              required=true,
     *              type="string",
     *              default="Ram",
     *      ),
     *      @SWG\Parameter(
     *              name="bank_details",
     *              in="formData",
     *              required=true,
     *              type="string",
     *              default="Chennai",
     *      ),
     *      @SWG\Parameter(
     *              name="customer_contact_number",
     *              in="formData",
     *              required=flase,
     *              type="number",
     *              default="9876543210",
     *      ),
     *      @SWG\Parameter(
     *              name="customer_code",
     *              in="formData",
     *              required=true,
     *              type="number",
     *              default="123",
     *      ),
          *      @SWG\Parameter(
     *              name="amount",
     *              in="formData",
     *              required=true,
     *              type="number",
     *              default=100,
     *      ),
          *      @SWG\Parameter(
     *              name="payment_type_id",
     *              in="formData",
     *              required=true,
     *              type="number",
     *              default=3,
     *      ),
          *      @SWG\Parameter(
     *              name="currency_id",
     *              in="formData",
     *              required=true,
     *              type="number",
     *              default=2,
     *      ),
          *      @SWG\Parameter(
     *              name="invoice_division[1]",
     *              in="formData",
     *              required=true,
     *              type="number",
     *              default=1,
     *      ),
     *      @SWG\Parameter(
     *              name="branch_id",
     *              in="formData",
     *              required=true,
     *              type="number",
     *              default=3,
     *      ),
     *      @SWG\Parameter(
     *              name="pament_category_id",
     *              in="formData",
     *              required=true,
     *              type="number",
     *              default=2,
     *      ),
     *      @SWG\Parameter(
     *              name="invoice_number[1]",
     *              in="formData",
     *              required=true,
     *              type="number",
     *              default=324234,
     *      ),
     *      @SWG\Parameter(
     *              name="invoice_image[1]",
     *              in="formData",
     *              required=true,
     *              type="file",
     *      ),
     *      @SWG\Parameter(
     *              name="rv_form_image",
     *              in="formData",
     *              required=true,
     *              type="file",
     *      ),
     *      @SWG\Parameter(
     *              name="collector_name",
     *              in="formData",
     *              required=true,
     *              type="string",
     *              default="Paul",
     *      ),
     *      @SWG\Parameter(
     *              name="collector_email",
     *              in="formData",
     *              required=true,
     *              type="string",
     *              default="paul.e@contus.in",
     *      ),
     *      @SWG\Parameter(
     *              name="collector_id",
     *              in="formData",
     *              required=true,
     *              type="number",
     *              default=23,
     *      ),
     *      @SWG\Parameter(
     *              name="collector_mobile_number",
     *              in="formData",
     *              required=true,
     *              type="number",
     *              default=9876543567,
     *      ),
     *    @SWG\Response(response=200, description="RV list Sucessfully given"),
     *    @SWG\Response(response=422, description="RV list is empty"),
     *    @SWG\Response(response=401, description="Token is invalid / Token is expired")
     * )
     */
    /**
     * This method is use as a common method for both store and update email templates
     *
     * @param array $requestData            
     * @param int $id            
     * @return boolean
     */
    public function addRVForm() {
            $userRules = ['rv_form_number' => 'required|unique:rv_form_details,rv_form_number',
                        'rv_created_date' => 'required',
                        'rv_form_image' => 'required',
                        'customer_name' => 'required',
                        'customer_code' => 'required',
                        'amount' => 'required',
                        'payment_type_id' => 'required',
                        'currency_id' => 'required',
                        'branch_id' => 'required', 
                        'pament_category_id' => 'required', 
                        'invoice_number' => 'required', 
                        'invoice_division' => 'required', 
                        'collector_name' => 'required', 
                        'collector_email' => 'required', 
                        'collector_mobile_number' => 'required', 
                        'collector_id' => 'required',];
        $this->setRules($userRules);
        $this->_validate();
        $rvimagename = $this->request->rv_form_image->getClientOriginalName();
        $ext = explode(".", $rvimagename);
        $renamervimagename = $this->request->rv_form_number.'.'.end($ext);
        $this->request->rv_form_image->move(public_path().'/files/', $renamervimagename);     
        $invoiceNumbers=$this->request->invoice_number;
        $invoiceDivisions=$this->request->invoice_division;
        $invoiceImages=$this->request->invoice_image;
        $this->rVForm->rv_form_image = $renamervimagename;
        $imageNames=[$renamervimagename];
        if(count($invoiceNumbers) == count($invoiceDivisions)){
            for($i = 1; $i < count($invoiceNumbers)+1; $i++){
                $this->rVInvoiceImages = new RVInvoiceImages(); 
                if (isset($invoiceImages[$i])) {          
                $imagename = $invoiceImages[$i]->getClientOriginalName();
                $extension=explode(".", $imagename);
                $invoiceImageName = $this->request->rv_form_number.'-'.$invoiceNumbers[$i].'-'.$invoiceDivisions[$i].'.'.end($extension);   
                   $invoiceImages[$i]->move(public_path().'/files/', $invoiceImageName);
                array_push($imageNames,$invoiceImageName);
                $this->rVInvoiceImages->invoice_image=$invoiceImageName;
        }
                $this->rVInvoiceImages->invoice_number=$invoiceNumbers[$i];
                $this->rVInvoiceImages->invoice_division=$invoiceDivisions[$i];
                $this->rVInvoiceImages->rv_form_number=$this->request->rv_form_number;
                $this->rVInvoiceImages->save ();
        } 
        $this->rVForm->fill($this->request->all());
        if ($this->rVForm->save ()) {
            $invoiceDetails= [$invoiceNumbers,$imageNames,$invoiceDivisions];
           $this->prepareEmailToSalse($this->rVForm,$invoiceDetails);
            return $this->getSuccessJsonResponse([], 'Rv Form Sucessfully created', 200);
        }else{
            return $this->getErrorJsonResponse([], 'internal error', 422);
        }
    }
}

    /**
     * This method is use as a send  email to accounts team
     *
     * @param array $requestData            
     * @param int $id            
     * @return boolean
     */

    public function prepareEmailToSalse($rVForm,$invoiceDetails){
      $currency = $this->currencies->where('id',$rVForm->currency_id)->first();
      $payment_type = $this->paymentType->where('id',$rVForm->payment_type_id)->first();
      $branch = $this->branches->where('id',$rVForm->branch_id)->first();
      $pament_category = $this->paymentCategory->where('id',$rVForm->pament_category_id)->first();
      $this->sendEmailToAccountTeam($rVForm,$invoiceDetails,$currency,$payment_type,$branch,$pament_category);
    }


    /**
     * Function to send the email notification
     *
     * @return array
     */
    public function sendEmailToAccountTeam($rVForm,$invoiceDetails,$currency,$payment_type,$branch,$pament_category) {
        $accountsEmail= $this->setting->where('setting_name','accounts_team_email_address')->select('setting_value')->first();
        $accountsEmails = explode(",",$accountsEmail->setting_value);
        try {
            foreach ($accountsEmails as $email) {              
            $response =Mail::to($email)->send(new SendRVToAccounts($rVForm,$invoiceDetails,$currency,$payment_type,$branch,$pament_category)); 
        }
        } catch (Exception $e) {
           $response = $e;            
        }
        if ($response===NULL) {
            return $this->getSuccessJsonResponse([], 'RV form send to accounts team suceessfully', 200);
        }else{
             return $this->getErrorJsonResponse([], 'RV form not able to send to accounts team', 422);
        }

}


    /**
     * @SWG\Get(
     *      path="/api/v1/rvoptions",
     *      tags={"Get RV Options"},
     *      operationId="getrvoptions",
     *      summary="Get RV options API",
     *      @SWG\Parameter(
     *              name="x-request-type",
     *              in="header",
     *              required=true,
     *              type="string",
     *              default="mobile",
     *      ),
     *      @SWG\Parameter(
     *              name="token",
     *              in="header",
     *              required=true,
     *              type="string",
     *              default="",
     *      ),
     *    @SWG\Response(response=200, description="RV options Sucessfully given"),
     *    @SWG\Response(response=401, description="Token is invalid / Token is expired"),
     *    @SWG\Response(response=422, description="RV options are empty or not activated")
     * )
     */


    /**
     * return RV form Options
     * set the grid model and relation model to be loaded
     *
     * @return Json
     */
    public function getRVOptions() {
        $branches = $this->branches->where('is_active',1)->select('id','branch_name')->get();
        $paymentType = $this->paymentType->where('is_active',1)->select('id','payment_name')->get();
        $paymentCategory = $this->paymentCategory->where('is_active',1)->select('id','category_name')->get();
        $currencies = $this->currencies->where('is_active',1)->select('id','currency_name')->get();
        $data = ["branches" => $branches,"paymentType" => $paymentType, "paymentCategory" => $paymentCategory,"currencies" =>$currencies];
        return $this->getSuccessJsonResponse(["data" => $data], 'RV options Sucessfully given', 200);
    }        


    /**
     * @SWG\Post(
     *      path="/api/v1/getrvlist",
     *      tags={"Get RV Lists"},
     *      operationId="getrvlist",
     *      summary="Get RV List API",
     *      @SWG\Parameter(
     *              name="x-request-type",
     *              in="header",
     *              required=true,
     *              type="string",
     *              default="mobile",
     *      ),
     *      @SWG\Parameter(
     *              name="token",
     *              in="header",
     *              required=true,
     *              type="string",
     *              default="",
     *      ),
     *      @SWG\Parameter(
     *              name="email",
     *              in="formData",
     *              required=true,
     *              type="string",
     *              default="sujankumar.s@contus.in",
     *      ),
     *    @SWG\Response(response=200, description="RV list Sucessfully given"),
     *    @SWG\Response(response=422, description="RV list is empty"),
     *    @SWG\Response(response=401, description="Token is invalid / Token is expired")
     * )
     */

    /**
     * Prepare the List view for RV form for Mobile Users
     * set the grid model and relation model to be loaded
     *
     * @return Json
     */
    public function getRVlist() {
        $userRules = [
                        'email' => 'required',
                        'rv_created_date' => 'required',
                        ];
        $this->setRules($userRules);
        $this->_validate();
        $email = $this->request->email;
        $date = $this->request->rv_created_date;
        $data = $this->rVForm->where ( 'collector_email', $email )->where('rv_created_date', 'like', '%' . $date . '%')->select('rv_form_number','customer_name','customer_code')->paginate(10);
         if ($data) {
            return $this->getSuccessJsonResponse(['data' => $data], 'RV list Sucessfully given', 200);
        }else{
            return $this->getErrorJsonResponse([], 'RV list is empty', 422);
        }
    }


    /**
     * @SWG\Post(
     *      path="/api/v1/rvdetail",
     *      tags={"RV Detail"},
     *      operationId="RV Detail",
     *      summary="Get RV detail API",
     *      @SWG\Parameter(
     *              name="x-request-type",
     *              in="header",
     *              required=true,
     *              type="string",
     *              default="mobile",
     *      ),
     *      @SWG\Parameter(
     *              name="token",
     *              in="header",
     *              required=true,
     *              type="string",
     *              default="",
     *      ),
     *      @SWG\Parameter(
     *              name="rv_form_number",
     *              in="formData",
     *              required=true,
     *              type="number",
     *              default=1,
     *      ),
     *    @SWG\Response(response=200, description="RV details Sucessfully given"),
     *    @SWG\Response(response=422, description="User not exists or User not activated"),
     *    @SWG\Response(response=401, description="Token is invalid / Token is expired")
     * )
     */




     /**
     * Prepare the List view for RV form for Mobile Users
     * set the grid model and relation model to be loaded
     *
     * @return Json
     */
    public function getRVDetail() {
        $userRules = [
                    'rv_form_number' => 'required',
                    ];
        $this->setRules($userRules);
        $this->_validate();
        $rv_form_number = $this->request->rv_form_number;
        $id =$this->rVForm->where('rv_form_number',$rv_form_number)->first();
    if($id){
       $data = (new RVForm())->with(['paymentType','paymentCategory','currencies','branches','rvInvoice'])->find($id->id)->toArray();
        return $this->getSuccessJsonResponse(['data'=> $data], 'RV details Sucessfully given', 200);
    }else{
        return $this->getErrorJsonResponse([], 'No records found for given RV form Number', 422);
        }
    }
     
       /**
     * @SWG\Post(
     *      path="/api/v1/search",
     *      tags={"Search RV Lists"},
     *      operationId="search",
     *      summary="Search RV List API",
     *      @SWG\Parameter(
     *              name="x-request-type",
     *              in="header",
     *              required=true,
     *              type="string",
     *              default="mobile",
     *      ),
     *      @SWG\Parameter(
     *              name="token",
     *              in="header",
     *              required=true,
     *              type="string",
     *              default="",
     *      ),
     *      @SWG\Parameter(
     *              name="search_term",
     *              in="formData",
     *              required=true,
     *              type="string",
     *              default="1",
     *      ),
     *    @SWG\Response(response=200, description="RV list Sucessfully given"),
     *    @SWG\Response(response=422, description="No records found"),
     *    @SWG\Response(response=401, description="Token is invalid / Token is expired")
     * )
     */  

    /**
     * Prepare the List view for RV form for Mobile Users
     * set the grid model and relation model to be loaded
     *
     * @return Json
     */
    public function rVSearch() {
        $userRules = [
                    'search_term' => 'required',
                     ];
        $this->setRules($userRules);
        $this->_validate();
    $search_term = $this->request->search_term;
    $email = $this->request->email;
    $result = $this->rVForm->where('collector_email',$email)
                ->where(function ($query)use ($search_term) {
                $query->where('rv_form_number', 'like', '%' . $search_term . '%')
                      ->orWhere('customer_name', 'like', '%' . $search_term . '%')
                      ->orWhere('customer_code', 'like', '%' . $search_term . '%');
            })->get();
   if($result){
        return $this->getSuccessJsonResponse(['data'=> $result], 'RV list Sucessfully given', 200);
    }else{
        return $this->getErrorJsonResponse([], 'No records found', 422);
        }
    }
    
        /**
     * File Export Code
     *
     * @var array
     */
    public function downloadFile()
    {
        $startDate=$this->request->input('first');
        $endDate=$this->request->input('last');
        $products = (new RVForm())->with(['paymentType','paymentCategory','currencies','branches','rvInvoice'])->whereBetween('rv_created_date', [date("Y-m-d", strtotime($startDate)), date("Y-m-d", strtotime($endDate))])->get()->toArray();
        foreach ($products as $key => $value) {
                  $products[$key]['payment_type'] = $products[$key]['payment_type']['payment_name'];
                  $products[$key]['currencies'] = $products[$key]['currencies']['currency_name'];
                  $products[$key]['branches'] = $products[$key]['branches']['branch_name'];
                  $products[$key]['payment_category'] = $products[$key]['payment_category']['category_name'];
                  unset($products[$key]['updated_at']);
                  unset($products[$key]['created_at']);
                  unset($products[$key]['pament_category_id']);
                  unset($products[$key]['branch_id']);
                  unset($products[$key]['division_id']);
                  unset($products[$key]['currency_id']);
                  unset($products[$key]['payment_type_id']);
                  unset($products[$key]['rv_form_image']);
                  $invoices = $products[$key]['rv_invoice'];
                  $products[$key]['rv_invoice_division']='';
                  $invoice_details='';
                  if ($invoices) {
                   foreach ($invoices as $count => $value) {
                    $name = $invoices[$count]['invoice_number'].'-'.$invoices[$count]['invoice_division'];
                    $invoice_details=$name.','.$invoice_details;
                   }
                   $products[$key]['rv_invoice_division']=$invoice_details;
                  }
                  unset($products[$key]['rv_invoice']);
                   
            }
            $excelName='RV_DATA_'.date('Y-m-d');
        return \Excel::create($excelName, function($excel) use ($products) {
            $excel->sheet('sheet name', function($sheet) use ($products)
            {
                $sheet->fromArray($products);
            });
        })->download('xlsx');
    }

}
