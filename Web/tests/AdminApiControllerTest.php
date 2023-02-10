<?php
/**
 * AdminApiControllerTest
 *
 * To manage admin api related test cases.
 *
 * @name       AdminApiControllerTest
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
class AdminApiControllerTest extends TestCase {
 use DatabaseTransactions;
 /**
  * class intializer
  *
  * @param array $testCaseByResources
  * @return void
  */
 public function __construct() {
  $ID = 2;
  $invalidID = 203;
  $this->setTestCaseByResources ( [
    static::RESOURCE_METHOD_INDEX => [
    'method' => 'GET',
    'path' => 'api/admin',
    'header' => 'Yes'
    ],
    static::RESOURCE_METHOD_INDEX => [
    'method' => 'GET',
    'path' => 'api/admin/create'
     ],
    static::RESOURCE_METHOD_INDEX => [
    'method' => 'GET',
    'path' => 'api/admin/1/edit'
     ],
    static::RESOURCE_METHOD_DESTROY => [
    'method' => 'DELETE',
    'path' => 'api/admin/destroy?id='.$ID
    ],
    static::RESOURCE_METHOD_INVALIDDESTROY => [
    'method' => 'DELETE',
    'path' => 'api/admin/destroy?id='.$invalidID
    ],
    static::RESOURCE_METHOD_NULLVALUE => [
    'method' => 'POST',
    'path' => 'api/admin',
    'param' => 'admintest.nullFieldValue',
    ],
    static::RESOURCE_METHOD_NULLVALUE => [
    'method' => 'POST',
    'path' => 'api/admin',
    'param' => 'admintest.nullFieldValueWeb',
    ]
    ]);
 }

/**
  * Function to add the existing email id
  *
  * @return void
  */
 public function testExistEmail() {
  $updatedResponse = $this->call ( 'POST', 'api/admin', config('admintest.emailAlreadyExist'),[],[],['HTTP_X-MOVERBEE-MOBILE' => 'Yes']);
  
  $this->assertEquals ( trans('codecoverage.emailExist'), $updatedResponse->getContent () );
 }
 
 /**
  * Function to add the existing email id
  *
  * @return void
  */
 public function testExistEmailWeb() {
  $updatedResponse = $this->call ( 'POST', 'api/admin', config('admintest.emailAlreadyExistWeb'));
  $this->assertEquals ( trans('codecoverage.emailExist'), $updatedResponse->getContent () );
 }

 
 /**
  * Function to add the existing mobile number
  *
  * @return void
  */
 public function testExistMobileNo() {
  $updatedResponse = $this->call ( 'POST', 'api/admin', config('admintest.mobileNoExists'),[],[],['HTTP_X-MOVERBEE-MOBILE' => 'Yes']);
  $this->assertEquals ( trans('codecoverage.existMobileNumber'), $updatedResponse->getContent () );
 }
 
 /**
  * Function to add the existing mobile number
  *
  * @return void
  */
 public function testExistMobileNoWeb() {
  $updatedResponse = $this->call ( 'POST', 'api/admin', config('admintest.mobileNoExistsWeb'));
  $this->assertEquals ( trans('codecoverage.existMobileNumber'), $updatedResponse->getContent () );
 }
 
 /**
  * Function to check the invalid email format
  *
  * @return void
  */
 public function testInvalidEmailFormat() {
  $updatedResponse = $this->call ( 'POST', 'api/admin', config('admintest.invalidEmaiFormat'),[],[],['HTTP_X-MOVERBEE-MOBILE' => 'Yes'] );
  $this->assertEquals ( trans('codecoverage.invalidEmailFormat'), $updatedResponse->getContent () );
 }
 
 /**
  * Function to check the invalid email format
  *
  * @return void
  */
 public function testInvalidEmailFormatWeb() {
  $updatedResponse = $this->call ( 'POST', 'api/admin', config('admintest.invalidEmaiFormatWeb') );
  $this->assertEquals ( trans('codecoverage.invalidEmailFormat'), $updatedResponse->getContent () );
 }
 
 /**
  * Function to check the mismatch password
  *
  * @return void
  */
 public function testMismatchPassword() {
  $updatedResponse = $this->call ( 'POST', 'api/admin', config('admintest.mismatchPassword'),[],[],['HTTP_X-MOVERBEE-MOBILE' => 'Yes']);
  $this->assertEquals ( trans('codecoverage.mismatchPassword'), $updatedResponse->getContent () );
 }
 
/**
  * Function to check the invalid values
  * 
  * @return void
  */
 public function testInvalidValue() {
  $invalidResponse = $this->call ( 'POST', 'api/admin', config('admintest.invalidValue'),[],[],['HTTP_X-MOVERBEE-MOBILE' => 'Yes']);
  $this->assertEquals ( trans('codecoverage.invadlidFields'), $invalidResponse->getContent () );
 }
 
 /**
  * Function to check the invalid values
  *
  * @return void
  */
 public function testInvalidValueWeb() {
  $invalidResponse = $this->call ( 'POST', 'api/admin', config('admintest.invalidValueWeb'));
  $this->assertEquals ( trans('codecoverage.invalid-phone-number'), $invalidResponse->getContent () );
 }
 /**
  * Function to check the invalid values
  *
  * @return void
  */
 public function testIndex() {
  $getResponse = $this->call ( 'GET', 'api/admin',[],[],['HTTP_X-MOVERBEE-MOBILE' => 'Yes']);
  $this->assertEquals ( 200, $getResponse->getStatusCode () );
 }
 /**
  * Function to check the invalid values
  *
  * @return void
  */
 public function testCreateWeb() {
  $response = $this->call ( 'POST', 'api/admin', config('admintest.addAdminWeb'));
  $this->assertEquals ( trans('codecoverage.create'), $response->getContent () );
 }
 /**
  * Function to check the invalid values
  *
  * @return void
  */
 public function testCreate() {
  $response = $this->call ( 'POST', 'api/admin', config('admintest.addAdmin'),[],[],['HTTP_X-MOVERBEE-MOBILE' => 'Yes']);
  $this->assertEquals ( trans('codecoverage.create'), $response->getContent () );
 }
 
 /**
  * Function to check the invalid values
  *
  * @return void
  */
 public function testUpdateWeb() {
  $response = $this->call ( 'POST', 'api/admin', config('admintest.updateAdminWeb'));
  $this->assertEquals ( trans('codecoverage.update'), $response->getContent () );
 }
 /**
  * Function to check the invalid values
  *
  * @return void
  */
 public function testUpdate() {
  $response = $this->call ( 'POST', 'api/admin', config('admintest.updateAdmin'),[],[],['HTTP_X-MOVERBEE-MOBILE' => 'Yes']);
  $this->assertEquals ( trans('codecoverage.update'), $response->getContent () );
 }
 
 /**
  * Function to check the invalid values
  *
  * @return void
  */
 public function testFiltersName() {
  $response = $this->call ( 'GET', 'api/admin?filters[name]=a',[],[],['HTTP_X-MOVERBEE-MOBILE' => 'Yes']);
  $this->assertEquals ( 200, $response->getStatusCode());
 }
 
 /**
  * Function to check the invalid values
  *
  * @return void
  */
 public function testFiltersEmail() {
  $response = $this->call ( 'GET', 'api/admin?filters[email]=a',[],[],['HTTP_X-MOVERBEE-MOBILE' => 'Yes']);
  $this->assertEquals ( 200, $response->getStatusCode());
 }
 
 /**
  * Function to check the invalid values
  *
  * @return void
  */
 public function testFiltersCompany() {
  $response = $this->call ( 'GET', 'api/admin?filters[company]=a',[],[],['HTTP_X-MOVERBEE-MOBILE' => 'Yes']);
  $this->assertEquals ( 200, $response->getStatusCode());
 }
 
 /**
  * Function to check the invalid values
  *
  * @return void
  */
 public function testFiltersRole() {
  $response = $this->call ( 'GET', 'api/admin?filters[role]=1',[],[],['HTTP_X-MOVERBEE-MOBILE' => 'Yes']);
  $this->assertEquals ( 200, $response->getStatusCode());
 }
 
 /**
  * Function to check the invalid values
  *
  * @return void
  */
 public function testFiltersCreatedAt() {
  $response = $this->call ( 'GET', 'api/admin?filters[created_at]=2016-09-12',[],[],['HTTP_X-MOVERBEE-MOBILE' => 'Yes']);
  $this->assertEquals ( 200, $response->getStatusCode());
 }
 
 /**
  * Function to check the invalid values
  *
  * @return void
  */
 public function testFiltersStatus() {
  $response = $this->call ( 'GET', 'api/admin?filters[status]=1',[],[],['HTTP_X-MOVERBEE-MOBILE' => 'Yes']);
  $this->assertEquals ( 200, $response->getStatusCode());
 }
 
 /**
  * Function to check the invalid values
  *
  * @return void
  */
 public function testFiltersTab() {
  $response = $this->call ( 'GET', 'api/admin?filters[tab]=1',[],[],['HTTP_X-MOVERBEE-MOBILE' => 'Yes']);
  $this->assertEquals ( 200, $response->getStatusCode());
 }
 
 /**
  * Function to check the invalid values
  *
  * @return void
  */
 public function testFiltersDefault() {
  $response = $this->call ( 'GET', 'api/admin?filters[test]=hello',[],[],['HTTP_X-MOVERBEE-MOBILE' => 'Yes']);
  $this->assertEquals ( 200, $response->getStatusCode());
 }
 
 /**
  * Function to check the invalid values
  *
  * @return void
  */
 public function testFiltersGrid() {
  $response = $this->call ( 'GET', 'api/admin?intialRequest=1',[],[],['HTTP_X-MOVERBEE-MOBILE' => 'Yes']);
  $this->assertEquals ( 200, $response->getStatusCode());
 }
}
