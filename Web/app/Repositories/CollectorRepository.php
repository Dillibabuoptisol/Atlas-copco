<?php
/**
 * Collector Repository 
 *
 * To manage Collector  actions.
 *
 * @name       CollectorRepository
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Repositories;

use Admin\Models\Collector;
use Admin\Models\Setting;
use Contus\Base\Repositories\Repository;
use Admin\Models\EmailTemplate;

class CollectorRepository extends Repository {
    /**
     * Class initializer
     *
     * @return void
     */
    public function __construct(Collector $collector,Setting $setting) {
        parent::__construct ();
        $this->collector = $collector;
        $this->setting = $setting;
        $this->setRules ( array (
                'name' => 'required|max:30|unique:collector,name|Regex:/^[a-zA-Z][a-zA-Z0-9\ ._&\-\(\)\[\]]+$/',
                'email' => 'required|unique:collector,email|email',
                'mobile_number' => 'required|unique:collector,mobile_number|numeric|min:6|max:15',
                'collector_id' => 'required|unique:collector,collector_id|numeric|max:15',
        ) );
    }
    /**
   * This method is use to save the data in admin user tables
   *
   * @see \Contus\Base\Contracts\ResourceInterface::store()
   *
   * @return boolean
   */
  public function store() {
    return $this->addOrUpdateCollector ( $this->request->all () );
  }
      /**
     * Method to get rules, city, state and country for adding users for admin.
     *
     * @return array
     */
    public function create() {
        $newRules = $this->getRules ();
        return array (
                'rules' => $newRules
        );
    }
  

  /**
   * This method is use to update the admin user details based on the user id
   *
   * @see \Contus\Base\Contracts\ResourceInterface::update()
   * @return boolean
   */
  public function update() {
    return $this->addOrUpdateCollector ( $this->request->all (), $this->request->id );
  }
  
  /**
   * This method is use as a common method for both store and update.
   *
   * @param array $requestData          
   * @param int $id          
   * @return boolean
   */
  public function addOrUpdateCollector($requestData, $id = null) {
    /**
     * define the validation rules for collector registration and
     * for profile update
     *
     * @var array $userRules
     */
    $id = $this->request->has('id') ? $this->request->get('id') : '';
    $collector = $this->collector->findOrNew($id);
    if ($id) {
            $this->setRules([
                  'name' => 'required|max:30|Regex:/^[a-zA-Z][a-zA-Z0-9\ ._&\-\(\)\[\]]+$/',
                  'email' =>'required|unique:collector,email,'. $collector->id,
                  'mobile_number' =>'required|numeric|unique:collector,mobile_number,'. $collector->id,
                  'collector_id' =>'required|numeric|unique:collector,collector_id,'. $collector->id,
                 ])->_validate();
    }else{
        $collector = new Collector();
            $this->setRules([
          'name' => 'required|max:30|Regex:/^[a-zA-Z][a-zA-Z0-9\ ._&\-\(\)\[\]]+$/',
          'email' =>'required|unique:collector,email|email',
          'mobile_number' =>'required|numeric|unique:collector,mobile_number',
          'collector_id' =>'required|numeric|unique:collector,collector_id',
         ])->_validate();
         $setting = $this->setting->where('setting_name','collector_default_password')->select('setting_value')->first();
        $collector->password = bcrypt($setting->setting_value);
        $collector->fill( $this->request->all());
    }  
    $status = false;
    $collector->fill( $this->request->all());
    if ($collector->save ()) {
        $status = true;
    }
    if(!$id){
      $this->sendEmailToCollector( $collector->name, $this->request->email,$this->request->mobile_number,$setting->setting_value);
    }
         return $status;
}
  /**
   * Prepare the grid
   * set the grid model and relation model to be loaded
   *
   * @return \Contus\Base\Repositories\Repository
   */
  public function prepareGrid() {
   $this->setGridModel ( $this->collector );
    return $this;
  }
  /**
   * This method is use to soft delete the records
   *
   * @see \Contus\Base\Contracts\ResourceInterface::destroy()
   *
   * @return bool
   */
  public function destroy() {
    $id = $this->request->id;
    return $this->collector->where ( ID, $id )->update ( array (
        IS_ACTIVE => '0' 
    ) );
  }
  

      /**
     * Method to get the data of single record of collector template
     *
     * @see \Contus\Base\Contracts\ResourceInterface::edit()
     * @return array, id, list of email
     */
    public function edit($id) {
        return array (
                'id' => $id,
                'CollectorSingleInfo' => $this->collector->where ( 'id', $id )->select('collector_id','email','is_active','mobile_number','name')->first (),
                'rules' => $this->getRules ()
        );
    }


  /**
   * Update grid records collection query
   *
   * @param mixed $builder          
   * @return mixed
   */
  protected function updateGridQuery($collector) {
    /**
     * updated the grid query by using this function and apply the video condition.
     */
    $filters = $this->request->input('filters');
    if (! empty ( $filters )) {
      foreach ( $filters as $key => $value ) {
        switch ($key) {
          case 'name' :
            $collector->where ( 'name', 'like', '%' . $value . '%' )->get ();
            break;
          case 'mobile_number' :
            $collector->where ( 'mobile_number', 'like', '%' . $value . '%' )->get ();
            break;
          case 'email' :
            $collector->where ( 'email', 'like', '%' . $value . '%' )->get ();
            break;
          case 'collector_id' :
            $collector->where ( 'collector_id', 'like', '%' . $value . '%' )->get ();
            break;
          case 'tab' :
          case 'status' :
            if ($value != 'All') {
              $collector->where ( 'is_active', $value );
            }else{
              $collector->get();
            }
            break;
          case 'dateRange':
            $value = explode('-',trim($value));
            $value[1] = date("Y-m-d", strtotime("+1 day",strtotime($value[1])));
            $collector->whereBetween('created_at', [date("Y-m-d", strtotime($value[0])), date("Y-m-d", strtotime($value[1]))]);
            break;
          default :
            $collector->where ( $key, 'like', "%$value%" );
            break;
        }
      }
    }
    return $collector;
  }
  


      /**
     * Get the Email template contents
     * 
     * @param string $slug            
     * @return array
     */
    public function getCollectorTemplate($slug) {
        $this->collectorEmailTemplate = new EmailTemplate ();
        $collectorEmailTemplate = $this->collectorEmailTemplate->where ( 'slug', $slug )->get ()->toArray ();
        return array_shift ( $collectorEmailTemplate );
    }

    /**
     * Send Password Reset Link to the User
     */

    public function sendEmailToCollector($name,$email,$mobile_number,$password){
       $collectorTemplate = $this->getCollectorTemplate ( 'collector_registration' );
            if (isset ( $collectorTemplate )){
                $logoImage = url('/').'/assets/images/Atlaslogo.png';
                $logolink = url('/');
                $emailSubject = $collectorTemplate ['subject'];
                $collectorEmailContent = $collectorTemplate ['body'];  
                $collectorEmailContent = str_replace ( array (
                        '{{LOGO}}',
                        '{{LOGOURL}}',
                        '{{USER}}',
                        '{{EMAIL}}',
                        '{{MOBILENUMBER}}',
                        '{{PASSWORD}}' 
                ), array (
                        $logoImage,
                        $logolink,
                        $name,
                        $email,
                        $mobile_number,
                        $password 
                ), $collectorEmailContent );
                return $this->sendCollectorRegisterationEmail ( $email, $collectorEmailContent, $emailSubject );

            }else {
                return $this->getErrorJsonResponse([], 'Email data is not available', 422);
            }
}

    /**
     * Function to send the email notification
     *
     * @return array
     */
    public function sendCollectorRegisterationEmail($email, $collectorEmailContent, $emailSubject) {
        $fromEmail = env('MAIL_USERNAME');
        try {
            $responce = app ( 'mailer' )->send ( [ ], [ ], function ($message) use ($fromEmail, $email, $emailSubject, $collectorEmailContent) {
            $message->to ( $email )->from ( $fromEmail, 'Atlas Copco' )->subject ( $emailSubject )->setBody ( $collectorEmailContent, 'text/html' );
        } );
        } catch (Exception $e) {
           $responce = $e;
            
        }
        if ($responce   ===NULL) {
            return $this->getSuccessJsonResponse([], 'Forgot password email sucessfully send', 200);
        }else{
             return $this->getErrorJsonResponse([], 'Forgot password email not able to send', 422);
        }

}
}