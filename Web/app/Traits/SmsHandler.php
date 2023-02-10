<?php

/**
 * To manage Sms handler configuration exception
 *
 * @name       SmsHandler
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Admin\Models\AdminUser;
use Admin\Traits\ResponseHandler;

trait SmsHandler {
 /**
  * This method is use to integrate the sms gateway
  * 
  * @param url $tanlaUrl
  * @return Ambigous <multitype:, multitype:string >
  */
 public function smsJsonResponse($tanlaUrl){
  $url = str_replace ( " ", "%20", $tanlaUrl );
  $response = $this->get_web_page ( $url );
  $responseData = explode ( 'MSGID:', $response );
  $resArr = array ();
  if (isset ( $responseData [1] ) && $responseData [1] != $responseData [0]) {
   $resArr = array (
    'MSGID' => trim ( $responseData [1] ),
    'success' => '1',
    'message' => 'Activation code send successfully'
   );
  } else {
   $resArr = array (
    'MSGID' => htmlentities ( $responseData [0] ),
    'success' => '0',
    'message' => 'Oh something went wrong, Please try again!'
   );
  }
  return $resArr;
 }
/**
 * This method is use to trigger sms gateway and send the verification code
 * 
 * @package string $url
 * @return array response
 */
public function get_web_page($url) {
 $ch = curl_init ();
 curl_setopt ( $ch, CURLOPT_URL, $url );
 curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
 $output = curl_exec ( $ch );
 curl_close ( $ch );
 return $output;
}
}