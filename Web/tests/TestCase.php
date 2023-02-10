<?php
abstract class TestCase extends Illuminate\Foundation\Testing\TestCase {
/**
 * The base URL to use while testing the application.
 *
 * @var string
 */
protected $baseUrl = 'http://localhost';
/**
 * Class constants for holding resource method available
 *
 * @var const
 */
const RESOURCE_METHOD_INDEX = 'index';
const RESOURCE_METHOD_CREATE = 'create';
const RESOURCE_METHOD_NULLVALUE = 'nullValue';
const RESOURCE_METHOD_INVALIDFIELD = 'invalidField';
const RESOURCE_METHOD_UPDATE = 'update';
const RESOURCE_METHOD_DESTROY = 'destroy';
const RESOURCE_METHOD_INVALIDDESTROY = 'invalidDestroy';
/**
 * The auth registered on Base Controller.
 *
 * @var object
 */
protected static $resourceMethods = [ 
 self::RESOURCE_METHOD_INDEX,
 self::RESOURCE_METHOD_CREATE,
 self::RESOURCE_METHOD_NULLVALUE,
 self::RESOURCE_METHOD_INVALIDFIELD,
 self::RESOURCE_METHOD_UPDATE,
 self::RESOURCE_METHOD_DESTROY,
 self::RESOURCE_METHOD_INVALIDDESTROY 
];
/**
 * The base URL to use while testing the application.
 *
 * @var array
 */
protected $testCaseByResources = [ 
 self::RESOURCE_METHOD_INDEX => [ ],
 self::RESOURCE_METHOD_CREATE => [ ],
 self::RESOURCE_METHOD_NULLVALUE => [ ],
 self::RESOURCE_METHOD_INVALIDFIELD => [ ],
 self::RESOURCE_METHOD_UPDATE => [ ],
 self::RESOURCE_METHOD_DESTROY => [ ],
 self::RESOURCE_METHOD_INVALIDDESTROY => [ ] 
];
/**
 * Creates the application.
 *
 * @return \Illuminate\Foundation\Application
 */
public function createApplication() {
 $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->
 bootstrap ();
 
 return $app;
}
/**
 * Set testCaseByResources
 *
 * @param array $testCaseByResources         
 * @return void
 */
public function setTestCaseByResources(array $testCaseByResources) {
 $this->testCaseByResources = $testCaseByResources;
}
/**
 * Check resoucre method data exists
 *
 * @param
 *         string method`
 * @return boolean
 */
public function isResourceDataExist($method) {
 return (isset ( $this->testCaseByResources [$method] ) && ! empty ( $this->testCaseByResources [$method] ));
}
/**
 * A basic functional test for the list action.
 *
 * @return void
 */
public function testIndex() {
 if ($this->isResourceDataExist ( static::RESOURCE_METHOD_INDEX )) {
  $method = $path = null;
  extract ( $this->testCaseByResources [static::RESOURCE_METHOD_INDEX] );
  $this->call ( $method, $path );
 }
}
/**
 * A basic functional test for the add action.
 *
 * @return void
 */
public function testCreate() {
 if ($this->isResourceDataExist ( static::RESOURCE_METHOD_CREATE )) {
  $method = $path = $param = null;
  extract ( $this->testCaseByResources [static::RESOURCE_METHOD_CREATE] );
  $addResponse = $this->call ( $method, $path, config ( $param ) );
  $this->assertEquals ( trans ( 'codecoverage.create' ), $addResponse->getContent () );
 }
}
/**
 * A basic functional test for the update action.
 *
 * @return void
 */
public function testUpdate() {
 if ($this->isResourceDataExist ( static::RESOURCE_METHOD_UPDATE )) {
  $method = $path = $param = null;
  extract ( $this->testCaseByResources [static::RESOURCE_METHOD_UPDATE] );
  $updateResponse = $this->call ( $method, $path, config ( $param ) );
  $this->assertEquals ( trans ( 'codecoverage.update' ), $updateResponse->getContent () );
 }
}
/**
 * A basic functional test for the delete action.
 *
 * @return void
 */
public function testDestroy() {
 if ($this->isResourceDataExist ( static::RESOURCE_METHOD_DESTROY )) {
  $method = $path = null;
  extract ( $this->testCaseByResources [static::RESOURCE_METHOD_DESTROY] );
  $destroyResponse = $this->call ( $method, $path );
  $this->assertEquals ( trans ( 'codecoverage.delete' ), $destroyResponse->getContent () );
 }
}
/**
 * A basic functional test for the invalid delete action.
 *
 * @return void
 */
public function testInvalidDestroy() {
 if ($this->isResourceDataExist ( static::RESOURCE_METHOD_INVALIDDESTROY )) {
  $method = $path = null;
  extract ( $this->testCaseByResources [static::RESOURCE_METHOD_INVALIDDESTROY] );
  $destroyResponse = $this->call ( $method, $path );
  $this->assertEquals ( trans ( 'codecoverage.invalidDelete' ), $destroyResponse->getContent () );
 }
}
/**
 * A basic functional test for the null values.
 *
 * @return void
 */
public function testNullValue() {
 if ($this->isResourceDataExist ( static::RESOURCE_METHOD_NULLVALUE )) {
  $method = $path = $param = null;
  extract ( $this->testCaseByResources [static::RESOURCE_METHOD_NULLVALUE] );
  $nullResponse = $this->call ( $method, $path, config ( $param ) );
  $this->assertEquals ( trans ( 'codecoverage.nullValue' ), $nullResponse->getContent () );
 }
}
/**
 * A basic functional test for the invalid field values.
 *
 * @return void
 */
public function testInvalidField() {
 if ($this->isResourceDataExist ( static::RESOURCE_METHOD_INVALIDFIELD )) {
  $method = $path = $param = null;
  extract ( $this->testCaseByResources [static::RESOURCE_METHOD_INVALIDFIELD] );
  $invalidFieldResponse = $this->call ( $method, $path, config ( $param ) );
  $this->assertEquals ( trans ( 'codecoverage.invadlidField' ), $invalidFieldResponse->getContent () );
 }
}
}
