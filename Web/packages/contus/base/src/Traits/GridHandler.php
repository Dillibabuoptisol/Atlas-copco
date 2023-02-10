<?php
/**
 * To manage grid handler configuration exception
 *
 * @name       GridHandler
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Contus\Base\Traits;

use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use InvalidArgumentException;

trait GridHandler {
    /**
     * Class property to hold the grid model
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $gridModel = null;
    /**
     * Class property to hold the related model loaded in eagarLoading
     *
     * @var mixed
     */
    protected $eagerLoadingModels = [ ];
    /**
     * Prepare the grid
     * should be overridden
     *
     * @return object $this
     */
    public function prepareGrid() {
        return $this;
    }
    /**
     * Set gridmodel property
     *
     * @param \Illuminate\Database\Eloquent\Model $gridModel            
     * @return object $this
     */
    protected function setGridModel(Model $gridModel) {
        $this->gridModel = $gridModel;        
        return $this;
    }
    /**
     * Set gridmodel related model loaded(eagar loading)
     *
     * @param mixed $eagerLoadingModels            
     * @return object $this
     */
    protected function setEagerLoadingModels($eagerLoadingModels) {
        $this->eagerLoadingModels = $eagerLoadingModels;        
        return $this;
    }
    /**
     * update grid records collection query
     *
     * @param mixed $builder           
     * @return mixed
     */
    protected function updateGridQuery($builder) {
        return $builder;
    }
    /**
     * Function used to retrieve records with field sorting(asc/desc) from database
     *
     * @return \Illuminate\Database\Eloquent\Collection | array
     * @throws \Exception
     */
    public function getRecords() {
        $collection = [];
        if($this->gridModel instanceof Model){
            $orderByFieldName = $rowsPerPage = $sortOrder = null;
            extract ( $this->request->all () );
            $pageLimit = ( int ) ((is_numeric ( $rowsPerPage )) ? $rowsPerPage : config ( 'admin.limit.gridLimit' ));
            $query = $this->updateGridQuery ( $this->gridModel->with ( $this->eagerLoadingModels ) );        
            try {
                if (! $query instanceof Builder && ! $query instanceof Model) {
                    throw new InvalidArgumentException ( '[upateGridQuery] should return the Builder Instance' );
                }
                if($this->request->queryType == 'subquery') {
                   $collection = $query->paginate ( $pageLimit );
                } else {
                    $collection = (is_null ( $orderByFieldName ) || is_null ( $sortOrder )) ? $query->orderBy ( 'id', 'desc' )->paginate ( $pageLimit ) : $query->orderBy ( $orderByFieldName, $sortOrder )->paginate ( $pageLimit );
                }
            } catch ( QueryException $e ) {
                $this->logger->error ( $e->getMessage () );
            } catch ( MongoCursorException $e ) {
                $this->logger->error ( $e->getMessage () );
            } catch ( Exception $e ) {
                $this->logger->error ( $e->getMessage () );
            }
        }
        return $this->getFormattedGridCollection ( $collection );
    }
    /**
     * Get additional information for grid
     * helper method helps to append more information to grid
     *
     * @return array
     */
    public function getGridAdditionalInformation() {
        return [ ];
    }
    /**
     * Get Formatted grid response
     *
     * @param mixed $collection            
     * @return array
     */
    public function getFormattedGridCollection($collection) {     
        return ($collection instanceof LengthAwarePaginator) ? $collection->toArray () : [ ];
    }
    /**
     * delete the existing attribute
     * delete attribute in group
     *
     * @param array $ids            
     * @return boolean
     */
    public function gridDelete(array $ids) {
        $isDeleted = false; 

        if(!empty($ids)){
            $isDeleted = $this->gridModel
                              ->whereIn(($this->gridModel instanceof MongodbModel) ? '_id' : 'id', $ids)
                              ->delete ();
        }

        return $isDeleted;
    }
}