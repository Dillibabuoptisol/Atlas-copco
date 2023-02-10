<?php
return [ 
  /*
   * |-------------------------------------------------------------------------- | Code Coverage Language Lines |-------------------------------------------------------------------------- | | The following language lines are used by the user module |
   */

    'create' => '{"error":false,"statuscode":200,"message":"Created Successfully"}',
    'update' => '{"error":false,"statuscode":200,"message":"Updated Successfully"}',
    'delete' => '{"error":false,"statuscode":200,"message":"Deleted Successfully"}',
    'invalidDelete' => '{"error":true,"statuscode":500,"message":"Unable to delete now ! Please try again later"}',
    'nullValue' => '{"error":true,"statusCode":422,"messages":{"name":["The name field is required."]}}',
    'invadlidField' => '{"error":true,"statusCode":422,"messages":{"name":["The name field is required."]}}',
    'emailExist' => '{"error":true,"statusCode":422,"messages":{"email":["The email has already been taken."]}}',
    'existMobileNumber' => '{"error":true,"statusCode":422,"messages":{"mobile_number":["The mobile number has already been taken."]}}',
    'invalidEmailFormat' => '{"error":true,"statusCode":422,"messages":{"email":["The email must be a valid email address."]}}',
    'mismatchPassword' => '{"error":true,"statusCode":422,"messages":{"confirm_password":["The confirm password and password must match."]}}',
    'invalid-number' => '{"error":true,"statusCode":422,"messages":{"is_active":["The is active must be a number."]}}',
    'unable-process' => '{"error":true,"statuscode":500,"message":"Unable to process request ! Please try again later"}',
    'field-required' => '{"error":true,"statusCode":422,"messages":{"name":["The name has already been taken."]}}',
    'display-name' => '{"error":true,"statusCode":422,"messages":{"display_name":["The display name field is required."]}}',
    'active-number' => '{"error":true,"statusCode":422,"messages":{"is_active":["The is active must be a number."]}}',
    'invalid-email' => '{"error":true,"statuscode":422,"message":"The email you entered is incorrect. Please try again"}',
    'invalidemail' => '{"error":true,"statusCode":422,"messages":{"email":["The email must be a valid email address."]}}',
    'invalid-password' => '{"error":true,"statuscode":422,"message":"The password you entered is incorrect. Please try again"}',
    'both-email-pwd' => '{"error":true,"statuscode":422,"message":"The email you entered is incorrect. Please try again"}',
    'invalid-zone' => '{"error":true,"statusCode":422,"messages":{"zone":["The zone field is required."]}}',
    'cityid-with-string' => '{"error":true,"statusCode":422,"messages":{"city_id":["The city id must be a number."]}}',
    'invadlidFields' => '{"error":true,"statusCode":422,"messages":{"mobile_number":["The mobile number must be a number.","The mobile number must be between 9 and 15 digits."]}}',
    'child-product' => '{"error":true,"statusCode":422,"messages":{"name":["Child product type is required"]}}',
    'parent-id' => '{"error":true,"statusCode":422,"messages":{"docID":["Select a parent product type"]}}',
    'language-require' => '{"error":true,"statusCode":422,"messages":{"language":["The language field is required."]}}',
    'invalid-phone-number' => '{"error":true,"statusCode":422,"messages":{"mobile_number":["The mobile number must be a number."]}}',    
    'nullValueMonth' => '{"error":true,"statusCode":422,"messages":{"month":["The month field is required."]}}'	
];
