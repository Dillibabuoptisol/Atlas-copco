<?php
/**
 * AdminGroupApiControllerTest
 *
 * To manage admin group test related actions.
 *
 * @name       AdminGroupApiControllerTest
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
class AdminGroupApiControllerTest extends TestCase {
 use DatabaseTransactions;
 /**
  * class intializer
  *
  * @param array $testCaseByResources
  * @return void
  */
 public function __construct() {
  $ID = 1;
  $invalidID = 203;
  $this->setTestCaseByResources ( [
    static::RESOURCE_METHOD_INDEX => [
    'method' => 'GET',
    'path' => 'api/admingroup'
    ],
    static::RESOURCE_METHOD_CREATE => [
    'method' => 'POST',
    'path' => 'api/admingroup',
    'param' => 'admingrouptest.addAdminGroup'
    ],
    static::RESOURCE_METHOD_UPDATE => [
    'method' => 'POST',
    'path' => 'api/admingroup',
    'param' => 'admingrouptest.updateAdminGroup'
    ],
    static::RESOURCE_METHOD_DESTROY => [
    'method' => 'DELETE',
    'path' => 'api/admingroup/destroy?id='.$ID
    ],
    static::RESOURCE_METHOD_INVALIDDESTROY => [
    'method' => 'DELETE',
    'path' => 'api/admingroup/destroy?id='.$invalidID
    ],
    static::RESOURCE_METHOD_NULLVALUE => [
    'method' => 'POST',
    'path' => 'api/admingroup',
    'param' => 'admingrouptest.nullFieldValue'
    ],
    static::RESOURCE_METHOD_INVALIDFIELD => [
    'method' => 'POST',
    'path'   => 'api/admingroup',
    'param'  => 'admingrouptest.invalidField'
    ]
    ]);
 }
/**
 * Function to invalid data string in the admin group
 *
 * @return void
 */
public function testInValidStringAdminGroup() {
 $invalidValueResponse = $this->call ( 'POST', 'api/admingroup', config ( 'admingrouptest.invalidStringValue' ) );
 $this->assertEquals ( trans('codecoverage.invalid-number'), $invalidValueResponse->getContent () );
 }
}
