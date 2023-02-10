<?php
/**
 * Common resource CRUD response handler
 *
 * @name       CrudResponseHandler
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Base\Traits;

use Request;
use Exception;
use BadMethodCallException;
use Contus\Base\Contracts\ResourceInterface;
use Illuminate\Validation\ValidationException;
use Contus\Base\Exceptions\InvalidRequestException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait CrudResponseHandler {
    use ResponseHandler;
    /**
     * Return the model collection with pagination
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return $this->handleResourceMethod ( __FUNCTION__, func_get_args () );
    }
    /**
     * Prepare model creation dependent data
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return $this->handleResourceMethod ( __FUNCTION__, func_get_args () );
    }
    /**
     * update the model record
     *
     * @return \Illuminate\Http\Response
     */
    public function update() {
        return $this->handleResourceMethod ( __FUNCTION__, func_get_args () );
    }
    /**
     * Create new model record
     *
     * @return boolean
     */
    public function store() {
        return $this->handleResourceMethod ( ((Request::has ( ID )) ? static::RESOURCE_METHOD_UPDATE : __FUNCTION__), func_get_args () );
    }
    /**
     * Return request model record
     * 
     * @param int $id
     * @return object
     */
    public function show($id) {
        return $this->handleResourceMethod ( __FUNCTION__, [$id]);
    }
    /**
     * Return request model record with dependent data for editing
     *
     * @param int $id
     * @return array
     */
    public function edit($id) {
        return $this->handleResourceMethod ( __FUNCTION__, [$id] );
    }
    /**
     * destroy the model record
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy() {
        return $this->handleResourceMethod ( __FUNCTION__, func_get_args () );
    }
    /**
     * handle bulk action request
     *
     * @return \Illuminate\Http\Response
     */
    public function action() {
        return $this->handleResourceMethod ( __FUNCTION__, func_get_args () );
    }
    /**
     * Handle various resource methods
     *
     * @param string $method            
     * @param array $parameters            
     * @return \Illuminate\Http\Response
     * @throws BadMethodCallException
     */
    protected function handleResourceMethod($method, array $parameters = []) {
        $response = false;
        if ($this->isResourceMethod ( $method ) && $this->repository instanceof ResourceInterface) {
            try {
          $response = $this->repository->$method(...$parameters);
                switch ($method) {
                    case static::RESOURCE_METHOD_CREATE :
                    case static::RESOURCE_METHOD_INDEX :
                    case static::RESOURCE_METHOD_SHOW :
                    case static::RESOURCE_METHOD_EDIT :
                        $response = $this->getSuccessJsonResponse ( $response );
                        break;
                    case static::RESOURCE_METHOD_STORE :
                        $response = ($response) ? $this->getSuccessJsonResponse ( [ ], trans ( MESSAGE_CREATE_SUCCESS ) ) : $this->getErrorJsonResponse ( [ ], trans ( MESSAGE_CREATE_ERROR ) );
                        break;
                    case static::RESOURCE_METHOD_UPDATE :
                        $response = ($response) ? $this->getSuccessJsonResponse ( [ ], trans ( MESSAGE_UPDATE_SUCCESS ) ) : $this->getErrorJsonResponse ( [ ], trans ( MESSAGE_UPDATE_ERROR ) );
                        break;
                    case static::RESOURCE_METHOD_DESTROY :
                        $response = ($response) ? $this->getSuccessJsonResponse ( [ ], trans ( MESSAGE_DELETE_SUCCESS ) ) : $this->getErrorJsonResponse ( [ ], trans ( MESSAGE_DELETE_ERROR ) );
                        break;
                    case static::RESOURCE_METHOD_ACTION :
                        $response = ($response) ? $this->getSuccessJsonResponse ( [ ], trans ( MESSAGE_BULK_ACTION_SUCCESS ) ) : $this->getErrorJsonResponse ( [ ], trans ( MESSAGE_BULK_ACTION_ERROR ) );
                        break;
                    default :
                        $response = false;
                        break;
                }
            } catch ( ModelNotFoundException $exception ) {
                $this->logger->error ( $exception->getMessage () );
                $response = $this->getErrorJsonResponse ( [ ], trans ( MESSAGE_RESOURCE_NOT_EXISTS ), 404 );
            } catch ( ValidationException $exception ) {
                $response = $this->convertValidationExceptionToResponse ( $exception );
            } catch ( InvalidRequestException $exception ) {
                throw $exception;
            } catch ( Exception $exception ) {
                $this->logger->error ( $exception);
                $response = $this->getErrorJsonResponse ( [ ], trans ( MESSAGE_UNABLE_PROCESS_REQUEST ) );
            }
        }
        if ($response === false) {
            throw new BadMethodCallException ( "Method [$method] does not exist." );
        }
        return $response;
    }
}