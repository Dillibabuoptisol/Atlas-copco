<?php
/**
 * UserApi Test Cases
 *
 * To manage user related test cases.
 *
 * @name       UserApiControllerTest
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Log;
class UserApiControllerTest extends TestCase {
 use DatabaseTransactions;
 /**
  * Function to test cases the email and password for user login
  */
 public function testUserLogin() {
  $addResponse = $this->call ( 'POST', 'api/login', config('usertest.userLogin'));
  $this->assertEquals ( 200, $addResponse->getStatusCode () );
 }
 
 /**
  * Function to test cases in active status
  */
 public function testUserLoginInActive() {
  $addResponse = $this->call ( 'POST', 'api/login', config('usertest.userLoginInactive') );
  $response = $this->assertEquals ( '200', $addResponse->getStatusCode () );
 }
 
 /**
  * Function to test cases the forgot password
  */
 public function testForgotPassword() {
  $addResponse = $this->call ( 'POST', 'api/forgotpassword', config('usertest.forgotpassword'));
  $this->assertEquals ( 200, $addResponse->getStatusCode () );
 }
 
 /**
  * Function to test cases the invalid email id
  */
 public function testInvalidEmail() {
  $addResponse = $this->call ( 'POST', 'api/login', config('usertest.invalidEmail') );
  $this->assertEquals ( trans('codecoverage.invalid-email'), $addResponse->getContent () );
 }
 
 /**
  * Function to test cases the invalid password
  */
 public function testInvalidPassword() {
  $addResponse = $this->call ( 'POST', 'api/login', config('usertest.invalidPassword'));
  $this->assertEquals ( trans('codecoverage.invalid-password'), $addResponse->getContent () );
 }
 
 /**
  * Function to test cases the invalid both email and password
  */
 public function testInvalidBothEmailAndPwd() {
  $addResponse = $this->call ( 'POST', 'api/login', config('usertest.invalidBothMailPwd') );
  $this->assertEquals ( trans('codecoverage.both-email-pwd'), $addResponse->getContent () );
 }
 
 /**
  * Function to test cases the invalid email format
  */
 public function testInvalidEmailFormat() {
  $addResponse = $this->call ( 'POST', 'api/login', config('usertest.invalidEmailFormat') );
  $this->assertEquals ( trans('codecoverage.invalidemail'), $addResponse->getContent () );
 }
 
 /**
  * Function to test cases the invalid email format
  */
 public function testUnauthorized() {
  $addResponse = $this->call ( 'POST', 'api/login', config('usertest.unauthorized') );
  $this->assertEquals ( 200, $addResponse->getStatusCode());
 }
 
 /**
  * Function to test cases the invalid email format
  */
 public function testInvalidStatus() {
  $addResponse = $this->call ( 'POST', 'api/login', config('usertest.invalidStatus') );
  $this->assertEquals ( 422, $addResponse->getStatusCode());
 }
}
