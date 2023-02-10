<?php
/**
 * UploadController
 *
 * To manage files uploaded
 *
 * @name       UploadController
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Base\Controllers\Api;

use Exception;
use Contus\Base\Repositories\UploadRepository;
use Contus\Base\Exceptions\InvalidRequestException;
use Illuminate\Foundation\Validation\ValidatesRequests;

class UploadController extends ApiController{
     use ValidatesRequests;
     /**
      * The class property to hold the UploadRepository object
      *
      * @var \Contus\Base\Repositories\UploadRepository
      */
     protected $uploadRepository;
     protected $requestParamKey = 'image';
    /**
     * Create a new controller instance.
     *
     * @param \Contus\Base\Repositories\UploadRepository $uploadRepository
     * @return void
     */
    public function __construct(UploadRepository $uploadRepository) {
      parent::__construct ();
      $this->uploadRepository = $uploadRepository;
    }
    /**
     * Valiadate the files uploaded
     *
     * @return void
     * @throws \Contus\Base\Exceptions\InvalidRequestException
     */
    protected function validateUploadedFiles() {
    	if (!$this->request->has('service') || !in_array($this->request->get('service'), config('media.AllowedMedias'))){
    		throw new InvalidRequestException(trans('base::messages.upload_error'),403);
    	}
    
    	$serviceConfig = $this->uploadRepository->setModelIdentifier($this->request->get('service'))
    	->setConfig()
    	->getConfig();
    	
    	if(isset($serviceConfig->is_file) && $serviceConfig->is_file){
    		$this->requestParamKey = 'image';
    		$this->uploadRepository->setRequestParamKey($this->requestParamKey);
    	}
    
    	$this->uploadRepository->validate($this->request,$this->uploadRepository->defineRule()->getRules());
    }
    /**
    * Handle files uploaded
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function handleUpload() {
    	
        $response = false;
        $this->validateUploadedFiles(); 
        try {
            if(
                $this->request->hasFile('image')
                
            ){
            	$file = $this->request->file('image');
            	$filename = $file->getClientOriginalName();
            	if(substr($file	->getMimeType(), 0, 5) == 'image') {
            		$destinationPath = public_path(). '/assets/images/';
            	}else {
            		$destinationPath = public_path(). '/uploads/';
            	}
            	$file->move($destinationPath, $filename);
            	$response = $this->getSuccessJsonResponse(['info' => $filename],trans('base::messages.upload_success'));
            }
        } catch (Exception $e) {
            $this->logger->error($e);
        }

        return $response ?: $this->getErrorJsonResponse([],trans('base::messages.upload_error'));
    }             
}