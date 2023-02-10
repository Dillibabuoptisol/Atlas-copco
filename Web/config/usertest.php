<?php
return [ 
 /*
  * |-------------------------------------------------------------------------- | User test case |-------------------------------------------------------------------------- | | Stringliteral are defined here |
  */
 'userLogin' => [ 
  'email' => 'durgadevi@contus.in',
  'password' => 'admin123' 
 ],
 'userLoginInactive' => [ 
  'email' => 'durgadevi@contus.in',
  'password' => 'admin123' 
 ],
 'forgotpassword' => [ 
  'email' => 'durgadevi@contus.in',
  'is_sms' => 1 
 ],
 'invalidEmail' => [ 
  'email' => 'durgadevi@contus.ins',
  'password' => 'admin123' 
 ],
 'invalidPassword' => [ 
  'email' => 'durgadevi@contus.in',
  'password' => 'admin123s' 
 ],
 'invalidBothMailPwd' => [ 
  'email' => 'durgadevi@contus.ins',
  'password' => 'admin123s' 
 ],
 'invalidEmailFormat' => [ 
  'email' => 'durgadevicontus.ins',
  'password' => 'admin123s' 
 ],
 'unauthorized' =>[
 'email' => 'durgadevi@contus.in',
 'password' => 'admin123'
],
'invalidStatus' =>[
'email' => 'raju@contus.in',
'password' => 'admin123'
]
 
];

