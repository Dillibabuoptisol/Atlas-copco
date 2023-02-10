<?php
/**
 * Upload Repository
 *
 * To manage all UploadRepository related actions.
 *
 * @name       UploadRepository
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Base\Repositories;

use Illuminate\Contracts\Validation\Factory;
use Contus\Base\Contracts\AttachableInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Exception;
use Contus\Base\Exceptions\InvalidConfigurationException;

class UploadRepository extends Repository {
    /**
     * Class property to hold the request param key which is holding the uploaded file
     * 
     * @var string
     */
    protected $requestParamKey = 'image';
    /**
     * Class property to hold the request param key which is flag tell file removed or not after uploaded
     * 
     * @var string
     */
    public $removedFlagParamKey = 'removed';
    /**
     * Class property to hold the request param key which is flag tell file removed or not after uploaded
     * 
     * @var string
     */
    protected $tempImageParamKey = 'temp';
    /**
     * Class property to hold the config related to setting by model
     * 
     * @var object
     */
    protected $config = null;
    /**
     * Class property to hold the storge path
     * independend of the type of upload
     * 
     * @var object
     */
    protected $path = null;
    /**
     * Class property to hold the temp storge path
     * independend of the type of upload
     * 
     * @var object
     */
    protected $tempPath = null;
    /**
     * Class property to hold the uploaded file
     * In Case if it is a multiple upload it will be a array
     * else it a uploaded file object
     * 
     * @var mixed (array)
     */
    protected $uploadedFiles = [ ];
    /**
     * Class constants for holding various
     * Model identifier using upload repo
     * 
     * @var const
     */
    const MODEL_IDENTIFIER_ADMINUSER = 'admin-user';
    /**
     * Class property to hold the allowed model identifiers
     * 
     * @var array
     */
    protected $allowedModelIdentifier = [ 
            self::MODEL_IDENTIFIER_ADMINUSER,
    ];
    /**
     * Class property to hold the model identifier
     * 
     * @var string
     */
    protected $modelIdentifier = null;
    /**
     * Class property to hold the various model
     * 
     * @var Contus\Base\Contracts\AttachableInterface;
     */
    protected $model = null;
    /**
     * Class intializer
     * 
     * @return string
     */
    public function __construct() {
        parent::__construct ();
        app ( Factory::class )->extend ( 'resolution', function () {
            $arguments = func_get_args ();
            if (count ( $arguments ) > 3) {
                /**
                 * we make files as array so we can check the resolution for every file uploaded
                 */
                $files = is_array ( $arguments [1] ) ? $arguments [1] : [ 
                        $arguments [1] 
                ];
                if (($expectedResolution = array_shift ( $arguments [2] )) && strpos ( $expectedResolution, "x" ) !== false) {
                    list ( $expectedWidth, $expectedHeight ) = explode ( 'x', $expectedResolution );
                    /**
                     * we will validate each files using array filter
                     */
                    return count ( array_filter ( $files, function ($file) use ($expectedWidth, $expectedHeight) {
                        list ( $fileWidth, $fileHeight ) = getimagesize ( $file->getRealPath () );
                        
                        return $expectedWidth <= $fileWidth && $expectedHeight <= $fileHeight;
                    } ) ) == count ( $files );
                }
            }
            return false;
        } );
        app ( Factory::class )->replacer ( 'resolution', function ($message) {
            return str_replace ( ':resolution', $this->config->image_resolution, ucfirst ( $message ) );
        } );
    }
    /**
     * Prepare the file upload for temporary path
     * 1)validation
     * 2)temp upload path
     * 3)set the files from request to property
     *
     * @return Object UploadRepository
     *
     * @throws \Illuminate\Http\Exception\HttpResponseException
     */
    public function tempPrepare() {
        /**
         * abort the request with 404 if the model requested is not in the model allowed
         */
        if (! in_array ( $this->modelIdentifier, $this->allowedModelIdentifier )) {
            app ()->abort ( 404 );
        }        
        $this->setConfig ()->defineRule ();        
        $this->validate ( $this->request, $this->getRules () );        
        $this->setTemporaryStoragePath ()->setUploadedFilesFromRequest ();        
        return $this;
    }
    /**
     * define the validation rule
     * for the uploaded file
     *
     * @return Object UploadRepository
     */
    public function defineRule() {
        return $this->setRule ( $this->requestParamKey, (isset ( $this->config->is_file ) && ($this->config->is_file)) ? "required|mimes:{$this->config->supported_format}|max:" . ($this->config->maximum_file_size * 1024) : "required|mimes:{$this->config->supported_format}|resolution:{$this->config->image_resolution}|max:" . ($this->config->maximum_file_size * 1024) );
    }
    /**
     * set the image configuration by model
     * used by validation rules
     *
     * @return Object UploadRepository
     *
     * @throws Exception
     */
    public function setConfig() {
        $this->config = $this->getFileConfigurationByModel ( $this->modelIdentifier );
        /**
         * if Config is not set throw the exception
         */
        if (is_null ( $this->config )) {
            throw new InvalidConfigurationException ( "Image configuration is not Found for {$this->modelIdentifier}", 1 );
        }        
        return $this;
    }
    /**
     * Upload the file to temporary path
     * and store the file information in the session
     *
     * @return array $uploadedFiles
     *
     * @throws Symfony\Component\HttpFoundation\File\Exception\FileException
     */
    public function tempUpload() {
        $uploadedFiles = [ ];        
        try {
            foreach ( $this->uploadedFiles as $file ) {
                $fileName = $this->makeTemporaryFileName ( $file );                
                $file->move ( $this->path, $fileName );                
                $uploadedFiles [] = $fileName;
            }
        } catch ( Exception $e ) {
            $this->logger->error($e->getMessage());
        }        
        return $uploadedFiles;
    }
    /**
     * Upload the file to actual path from request
     * all the files are try to uploaded even if some file has exception
     * single file is send to the AttchableModel
     *
     * @return void
     *
     * @throws Symfony\Component\HttpFoundation\File\Exception\FileException
     */
    public function singleUpload() {
        $file = $this->request->file ( $this->requestParamKey );        
        try {
            $model = $this->model->getFileModel ()->setFile ( $file->move ( $this->path, $this->makeTemporaryFileName ( $file ) ) );
        } catch ( Exception $e ) {
            $this->logger->error ( $e->getMessage () );
        }        
        $this->model->upload ( $model );
    }
    /**
     * Upload the file to actual path from request
     * all the files are try to uploaded even if some file has exception
     * multiple file is send to the AttchableModel
     *
     * @return void
     *
     * @throws Symfony\Component\HttpFoundation\File\Exception\FileException
     */
    public function upload() {
        $fileModels = [ ];        
        foreach ( $this->request->file ( $this->requestParamKey ) as $file ) {
            try {
                $fileModels [] = $this->model->getFileModel ()->setFileOptions ( [ 
                        'name' => $file->getClientOriginalName () 
                ] )->setFile ( $file->move ( $this->path, $this->makeTemporaryFileName ( $file ) ) );
            } catch ( Exception $e ) {
                $this->logger->error ( $e->getMessage () );
            }
        }        
        $this->model->upload ( $fileModels );
    }
    /**
     * make temporary file name for the upload file
     *
     * @param Symfony\Component\HttpFoundation\File\UploadedFile $file            
     * @return array
     */
    protected function makeTemporaryFileName(UploadedFile $uploadedFile) {
        if (isset ( $this->config->is_file ) && ($this->config->is_file)) {
            return uniqid () . "." . pathinfo ( $uploadedFile->getClientOriginalName (), PATHINFO_EXTENSION );
        }
        return uniqid () . "." . ($uploadedFile->guessExtension () ?: pathinfo ( $uploadedFile->getClientOriginalName (), PATHINFO_EXTENSION ));
    }
    /**
     * set temporary as destination path
     *
     * @return object UploadRepository
     */
    protected function setTemporaryStoragePath() {
        $this->path = $this->makeOSFriendlyPath ( storage_path ( (isset ( $this->config->is_file ) && ($this->config->is_file)) ? $this->config->temporary_storage_path : $this->config->temporary_image_storage_path ) );        
        return $this;
    }
    /**
     * set storage path 
     *          
     * @return object UploadRepository
     */
    protected function setStoragePath() {
        $this->path = $this->makeOSFriendlyPath ( public_path ( $this->config->storage_path ) );        
        return $this;
    }
    /**
     * make path Operating System friedly
     * replace directory separator with DIRECTORY_SEPARATOR
     *
     * @param string $path            
     * @return string
     */
    protected function makeOSFriendlyPath($path) {
        $path = str_replace ( '\\', DIRECTORY_SEPARATOR, $path );
        return str_replace ( '/', DIRECTORY_SEPARATOR, $path );
    }
    /**
     * set uploaded file from the request
     * and make sure the uploadedFile class property has array of files
     *
     * @return object UploadRepository
     */
    protected function setUploadedFilesFromRequest() {
        $uploadedFile = $this->request->hasFile ( $this->requestParamKey ) ? $this->request->file ( $this->requestParamKey ) : [ ];        
        $this->uploadedFiles = is_array ( $uploadedFile ) ? $uploadedFile : [ 
                $uploadedFile 
        ];        
        return $this;
    }
    /**
     * Complete the upload by move the file from
     * temporary directory to the actual by model
     *
     * @return void
     */
    public function completeUpload() {
        $fileModels = [ ];        
        foreach ( $this->getFilesInformation () as $fileInfo ) {
            $filePath = $this->getTempPath () . $fileInfo [$this->tempImageParamKey];            
            if (! file_exists ( $filePath )) {
                $this->throwJsonResponse ( false, 403, trans ( 'upload.error.invalid' ) );
            }            
            if ($this->isRemovedFile ( $fileInfo )) {
                if (file_exists ( $filePath )) {
                    unlink ( $filePath );
                }
                continue;
            }            
            try {
                $fileModels [] = $this->model->getFileModel ()->setFileOptions ( $fileInfo )->setFile ( (new File ( $filePath, true ))->move ( $this->path ) );
            } catch ( FileNotFoundException $e ) {
                $this->logger->error ( $e->getMessage () );
            }
        }        
        $this->model->upload ( $fileModels );
    }
    /**
     * Complete the upload by move the file from
     * temporary directory to the actual by model
     *
     * @return void
     */
    public function completeSingleUpload() {
        $fileName = $this->request->input ( $this->requestParamKey );
        $fileModel = NULL;        
        $filePath = $this->getTempPath () . $fileName;        
        if (! file_exists ( $filePath )) {
            $this->throwJsonResponse ( false, 403, trans ( 'upload.error.invalid' ) );
        }        
        try {
            $fileModel = $this->model->getFileModel ()->setFile ( (new File ( $filePath, true ))->move ( $this->path ), $this->config->storage_path );            
            $this->model->upload ( $fileModel );
        } catch ( FileNotFoundException $e ) {
            p ( $e->getMessage () );
            $this->logger->error ( $e->getMessage () );
        }
    }
    /**
     * Check the file is removed by the user after uploaded
     * removed flag is true it will unlink the file (removed from file system)
     *
     * @param array $file            
     * @return boolean
     */
    protected function isRemovedFile(array $file) {
        return (array_key_exists ( $this->removedFlagParamKey, $file ) && ( int ) $file [$this->removedFlagParamKey] === 1);
    }
    /**
     * get temp storage path
     * Note : during actual file upload actual path class property is used
     *
     * @return string
     */
    protected function getTempPath() {
        if (is_null ( $this->tempPath )) {
            $this->tempPath = $this->makeOSFriendlyPath ( storage_path ( (isset ( $this->config->is_file ) && ($this->config->is_file)) ? $this->config->temporary_storage_path : $this->config->temporary_image_storage_path ) ) . DIRECTORY_SEPARATOR;
        }        
        return $this->tempPath;
    }
    /**
     * Handle the file uploads for the user
     * if file upload has happened in ajax it in temporary path
     * else the handle file uploaded in the latest request
     *
     * @param Contus\Base\Contracts\AttachableInterface $model            
     * @return mixed
     */
    public function handleUpload(AttachableInterface $model) {
        $this->model = $model;        
        if ($this->hasTemporaryUpload ()) {
            $this->setStoragePath ();            
            if (is_array ( $this->request->input ( $this->requestParamKey ) )) {
                $this->completeUpload ();
            } else {
                $this->completeSingleUpload ();
            }
        } else {
            $this->setStoragePath ();            
            if (is_array ( $this->request->file ( $this->requestParamKey ) )) {
                $this->upload ();
            } else {
                $this->singleUpload ();
            }
        }
    }
    /**
     * Check the file already uploaded to temporary path through AJAX by model identifier
     * and check file is not uploaded in the current request
     *
     * @return boolean
     */
    public function hasTemporaryUpload() {
        return $this->request->has ( $this->requestParamKey ) && ! $this->request->hasfile ( $this->requestParamKey );
    }
    /**
     * get the files information from request
     * for temporary upload
     * only the file information request param key contain tempImageParamKey will be considered for upload
     *
     * @return array
     */
    public function getFilesInformation() {
        return array_filter ( $this->hasTemporaryUpload () ? $this->request->input ( $this->requestParamKey ) : [ ], function ($file) {
            return isset ( $file [$this->tempImageParamKey] ) && ! empty ( $file [$this->tempImageParamKey] );
        } );
    }
    /**
     * Define file rule for repository
     * rule is defined only if there is not file in temporary path
     * and file is uploaded
     *
     * @param BaseRepository $repository            
     * @return boolean
     */
    public function defineRepositoryFileRule(Repository $repository) {
        if (! $this->hasTemporaryUpload () && $this->request->hasFile ( $this->requestParamKey )) {
            $repository->setRule ( $this->requestParamKey, $this->defineRule ()->getRule ( $this->requestParamKey ) );
        }
    }
}