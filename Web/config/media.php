<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Various Image Configuration by model
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many model based configuration such as supported_format
    | maximum_file_size in MB,image_resolution,thumb_image_resolution
    |
    */
    'AllowedMedias' => ['admin', 'myprofile', 'bulkupload'],
    	'admin' => [
				'supported_format' => 'jpg,png,jpeg',
				'maximum_file_size' => 2,
				'image_resolution' => '400x300',
				'thumb_image_resolution' => '120x90'
		],
		'myprofile' => [
				'supported_format' => 'jpg,png,jpeg',
				'maximum_file_size' => 2,
				'image_resolution' => '400x300',
				'thumb_image_resolution' => '120x90'
		],
		'bulkupload' => [
		        'supported_format' => 'xlsx,xls,csv',
		        'maximum_file_size' => 5,
		        'is_file' => 1
    	]
];
