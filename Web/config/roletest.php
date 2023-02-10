<?php
return [ 
 /*
  * |-------------------------------------------------------------------------- | Role test case |-------------------------------------------------------------------------- | | Stringliteral are defined here |
  */
 'addRole' => [ 
  'name' => 'Customer Supporting',
  'permissions' => ['Create','Update'],  
  'creator_id' => 1,
  'updator_id' => '1',
  '_token' => 'test',
  'is_active' => 1
 ],
 'updateRole' => [ 
  'name' => 'Telecallers',
  'permissions' => ['Create','Update'],
  'creator_id' => 1,
  'updator_id' => 1,
  'id' => '4',
  'is_active' => 1
 ],
 'nameAlreadyTaken' => [ 
  'name' => 'Developer',
  'permissions' => ['Create','Update'],
  'creator_id' => 1,
  'updator_id' => 1,
  'is_active' => 1
 ],
 'invalidRecords' => [ 
  'name' => 'Admin Z1ss',
  'permissions' => ['Create','Update'],
  'creator_id' => 1,
  'updator_id' => '1',
  'id' => '102',
  'is_active' => 1
 ],
 'nullFieldValue' => [ 
  'name' => '',
  'permissions' => ['Create','Update'],
  'creator_id' => 1,
  'updator_id' => '1',
  'is_active' => 1
 ] 
];

