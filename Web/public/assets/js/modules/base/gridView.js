/**
 * This file is used to create list view with pagination,search,sorting and delete features
 */
var gridObj = {
	/**
	 * Object property to hold the request param prefix
	 * 
	 * @var string
	 */
	requestParamPrefix : 'request',
	/**
	 * Object property to hold the request param Concatenator
	 * 
	 * @var string
	 */
	requestParamKeyConcatenator : '_',
	/**
	 * Object property to hold the filter param prefix
	 * 
	 * @var string
	 */
	filterParamPrefix : 'filter',
	/**
	 * Object property to hold the filter param Concatenator
	 * 
	 * @var string
	 */
	filterParamKeyConcatenator : '_',
	/**
	 * Function is used to show pagination link
	 * 
	 * @param object scope
	 * @param int totalLinks
	 * @return void
	 */
	paginate : function(scope, totalLinks) {
		scope.links = [];
		if (scope.currentPage > totalLinks) {
			return false;
		}
		var counter = Math.floor(scope.currentPage / 5);
		if (counter == 0) {
			counter = 1;
		} else {
			counter = counter * 5;
		}
		if ((totalLinks - counter) >= 5) {
			counterLimit = counter + 5;
		} else {
			counterLimit = totalLinks;
		}
		var initialCounter = counter + 5;
		if ((scope.currentPage > 1) && (totalLinks > 1)) {
			scope.links.push({
				value : 'Previous',
				pageNumber : scope.currentPage - 1,
				current : false
			});
		}
		if ((counter >= 4) && (totalLinks > 1)) {
			scope.links.push({
				value : 'First',
				pageNumber : 1,
				current : false
			});
		}
		for (counter; counter <= counterLimit; counter++) {

			if (scope.currentPage == counter) {
				scope.links.push({
					value : counter,
					pageNumber : counter,
					current : true
				});
			} else {
				scope.links.push({
					value : counter,
					pageNumber : counter,
					current : false
				});
			}
		}
		if ((initialCounter < totalLinks - 1) && totalLinks > 1) {
			scope.links.push({
				value : '...',
				pageNumber : null,
				current : false
			});
			scope.links.push({
				value : totalLinks - 1,
				pageNumber : totalLinks - 1,
				current : false
			});
			scope.links.push({
				value : totalLinks,
				pageNumber : totalLinks,
				current : false
			});
			scope.links.push({
				value : 'Next',
				pageNumber : scope.currentPage + 1,
				current : false
			});
		} else if ((initialCounter === totalLinks - 1) && totalLinks > 1) {
			scope.links.push({
				value : totalLinks,
				pageNumber : totalLinks,
				current : false
			});
			scope.links.push({
				value : 'Next',
				pageNumber : scope.currentPage + 1,
				current : false
			});
		} else if (scope.currentPage !== totalLinks && totalLinks > 1) {
			scope.links.push({
				value : 'Next',
				pageNumber : scope.currentPage + 1,
				current : false
			});
		}
	},
	/**
	 * Function is used to call getRecords method with startOffset and endOffset
	 * to get required set or records
	 * 
	 * @param object scope
	 * @param int pageNumber
	 * @param boolean orderStatus
	 * @return void
	 */
	getListRecord : function(scope, pageNumber, orderStatus) {
		if ((scope.currentPage == pageNumber || pageNumber == null)
				&& orderStatus == false) {
			return false;
		}
		scope.showRecords = false;
		scope.gridLoadingBar = true;
		scope.currentPage = pageNumber;
		scope.getRecords(true);
	},
	/**
	 * Function is used to call getListRecord method to sort(asc/desc) required
	 * field.
	 * 
	 * @param object scope
	 * @param object event
	 * @param string field
	 * @return void
	 */
	listFieldSorting : function(scope, event, field) {
		var element = event.target;
		if (element.id == 'gridAsc' || element.id == '') {
			angular.element('.listHeading').find('span').attr('id', '');
			element.id = 'gridDesc';
			scope.fieldName = field.toLowerCase();
			scope.sortOrder = 'desc';
		} else {
			angular.element('.listHeading').find('span').attr('id', '');
			element.id = 'gridAsc';
			scope.fieldName = field.toLowerCase();
			scope.sortOrder = 'asc';
		}
		this.getListRecord(scope, 1, true);
	},
	/**
	 * Function is used to delete required records.
	 * 
	 * @param object scope
	 * @return void
	 */
	deleteRecords : function(scope, $rootScope) {
		scope.showRecords = false;
		scope.gridLoadingBar = true;
		var selectedCheckboxLength = scope.selectedCheckbox.length;
		var queryString = (angular.isDefined(scope.requestParams.service)) ? {
			service : scope.requestParams.service
		} : {};

		scope.request.post(scope.request.getUrl(scope.moduleName + '/action'),
				angular.extend({}, {
					selectedCheckbox : scope.selectedCheckbox
				}, scope.requestParams), function(data) {
					this.responseMessage = data.message;
					this.showResponseMessage = true;
					scope.selectedCheckbox = [];
					angular.element('#selectall').removeAttr('checked');
					angular.element('.options-drop').hide();
					$rootScope.notification.add({
						isSuccess : true,
						message : data.message
					}).showNow($rootScope);
					if (scope.records.length - selectedCheckboxLength > 0) {
						scope.getRecords(true);
					} else {
						pageNumber = (scope.currentPage - 1 == 0) ? 1
								: scope.currentPage - 1;
						scope.currentPage = pageNumber;
						scope.getRecords(true);
					}
				});
	},
	/**
	 * Function is used to covert camel case to hypen string.
	 * 
	 * @param string str
	 * @return string
	 */
	camelCaseToHypens : function(str) {
		return angular.isString(str) ? str.replace(/([a-z])([A-Z])/g, '$1-$2')
				.toLowerCase() : '';
	},
	/**
	 * Function is used check directive data attribute should be used send in
	 * request or not also the request param is pushed
	 * 
	 * @param array attributeSplits
	 * @return boolean
	 */
	isGridRequestParam : function(attributeSplits) {
		return angular.isArray(attributeSplits) && attributeSplits.length > 0
				&& attributeSplits[0] == this.requestParamPrefix;
	},
	/**
	 * Function is used check directive data attribute should be used send in
	 * request filters or not also the filters is pushed
	 * 
	 * @param array attributeSplits
	 * @return boolean
	 */
	isGridFilterParam : function(attributeSplits) {
		return angular.isArray(attributeSplits) && attributeSplits.length > 0
				&& attributeSplits[0] == this.filterParamPrefix;
	},
	/**
	 * Function is used format and push the request params key will be
	 * concatenation of object property requestParamKeyConcatenator
	 * 
	 * @param object scope
	 * @param array attributeSplits
	 * @param string value
	 * @return void
	 */
	pushToRequestParams : function(scope, attributeSplits, value) {
		if (angular.isArray(attributeSplits) && angular.isObject(scope)
				&& angular.isObject(scope.requestParams)
				&& angular.isDefined(value)) {
			/**
			 * remove the prefix(gridObj.requestParamPrefix)
			 */
			attributeSplits.shift();

			scope.requestParams[attributeSplits
					.join(this.requestParamKeyConcatenator)] = value;
		}
	},
	/**
	 * Function is used format and push the request params key will be
	 * concatenation of object property requestParamKeyConcatenator
	 * 
	 * @param object scope
	 * @param array attributeSplits
	 * @param string value
	 * @return void
	 */
	pushToFilterParams : function(scope, attributeSplits, value) {
		if (
			angular.isArray(attributeSplits) 
			&& angular.isObject(scope)
			&& angular.isObject(scope.filters)
			&& angular.isDefined(value)
		) {
			/**
			 * remove the prefix(gridObj.filterParamPrefix)
			 */
			attributeSplits.shift();

			scope.filters[attributeSplits
					.join(this.filterParamKeyConcatenator)] = value;
		}
	},	
	/**
	 * Function is used to prepare attributes. set data attributes to scope
	 * property
	 * 
	 * @param object
	 *            scope
	 * @param object
	 *            attrs
	 * @return void
	 */
	prepareAttributes : function(scope, attrs) {
		angular.forEach(attrs, function($item, $key) {
			if (angular.isObject(scope) && angular.isString($item)) {
				var attributeSplits = gridObj.camelCaseToHypens($key)
						.split('-');

				if (gridObj.isGridRequestParam(attributeSplits)) {
					gridObj.pushToRequestParams(scope, attributeSplits, $item);
				} else if (gridObj.isGridFilterParam(attributeSplits)) {
					gridObj.pushToFilterParams(scope, attributeSplits, $item);
				} else {
					scope[$key] = $item;
				}
			}
		});
	},
};

var gridView = ['$document','requestFactory','$rootScope',function($document,requestFactory,$rootScope){
	var request = requestFactory;

	return {
		restrict : 'A',
		controllerAs : 'gridCtrl',
		controller : ['$http','$scope','$document','$attrs','$filter',function(
			$http,
			$scope,
			$document,
			$attrs,
			$filter
		) {
			$scope.requestParams = {};
			$scope.filters = {};
			$scope.tabSelected = 'All';
			gridObj.prepareAttributes($scope,$attrs);
			$scope.currentPage = 1;
			$scope.totalRecords = '';
			$scope.records = '';
			$scope.links = '';
			$scope.fieldName = '';
			$scope.sortBy = '';
			$scope.showRecords = false;
			$scope.gridLoadingBar = true;
			$scope.requiredPageNumber = '';
			$scope.pageLimit = '';
			$scope.showGridError = true;
			$scope.gridError = '';
			$scope.grid = {searchBy:'',rows:$scope.rowsPerPage};
			$scope.selectedCheckbox = [];
			$scope.noRecords = false;
			$scope.showDeleteBox = false;
			$scope.deleteParams = [];
			$scope.confirmationDeleteBox = false;
			$scope.alertBox = false;
			$scope.request = request;
			$scope.tableLoader = false;
			$scope.searchRecords = {};
			$scope.rowsPerPageOptions = {
				10 : 10,
				50 : 50,
				100 : 100
			};
			$scope.orderByField = null;
			$scope.sortByType = null;
			$scope.queryType = null;
			$scope.selectedRowsPerPage = "10";
			$scope.resetRecord = {};
			
			$scope.setSortOrder = function(colName, status, queryType){
				$scope.orderByField = colName;
				$scope.sortByType = status;
				$scope.queryType = queryType;
				$scope.getRecords(true);
			}
			
			if($scope.requestParams.service){
				$scope.request.currentService($scope.requestParams.service);
			}
			/**
			 * Function is used to retrieve records from database
			 * 
			 * @param boolean intialRequest
			 * @return object records details
			 */
			$scope.getRecords = function(intialRequest) {
				$scope.tableLoader = true;
				$scope.intialRequest = angular.isDefined(intialRequest) ? 1 : 0;

				var params = {
					page             : $scope.currentPage,
					rowsPerPage      : $scope.rowsPerPage,
					orderByFieldName : $scope.orderByField,
					sortByType		 : $scope.sortByType,
					queryType        : $scope.queryType,
					filters          : $scope.filters,
					intialRequest    : $scope.intialRequest
				};	

				if($scope.orderBy != '' && $scope.searchValue == '') {
					params.orderBy = $scope.orderBy;
					params.sortBy = $scope.sortOrder;
				}
				$scope.request.get(
					$scope.request.getUrl($scope.moduleName,angular.extend({},params,$scope.requestParams)),
					$scope.successCallback,
					$scope.errorCallback
				);
			}	
			
			/**
			 * Function is used to list view
			 * 
			 * @return void
			 */
			$scope.successCallback = function(response) {
				$scope.totalRecords = response.data.total;
				$scope.currentPage  = response.data.current_page;
				$scope.lastPage  	= response.data.last_page;
	    		$scope.tableLoader = false;
	    		$scope.gridLoadingBar = false;				
				$scope.pageLimit = Math.ceil($scope.totalRecords/$scope.rowsPerPage);
				if($scope.intialRequest && angular.isObject(response.heading)){
					$scope.heading = response.heading.heading;
				}				
				if($scope.intialRequest && angular.isObject(response.recordsCount)){
					$scope.recordsCount = response.recordsCount;
				}				
		    	if(response.data.total > 0 ) {
		    		$scope.showRecords = true;
		    		$scope.noRecords = false;
		    		$scope.records = response.data.data;
		    		$scope.moreInfo = response.moreInfo;
		    		$scope.showGridError = true;
					$scope.gridError = '';
					$scope.$emit('afterGetRecords',response);
		    	}
		    	else {
		    		$scope.showGridError = false;
		    		$scope.records = '';
		    		$scope.noRecords = true;
					$scope.gridError = 'No records found';
					$scope.searchValue = '';
					return false;
		    	}		    	
		    	gridObj.paginate($scope,$scope.pageLimit);
		    };
			$scope.errorCallback = function(data){
				$scope.tableLoader = false;
	    		$scope.gridLoadingBar = false;
			    $scope.showGridError = false;
			    $scope.noRecords = true;
			    $scope.searchValue = '';
			    $scope.records = '';
				$scope.gridError = 'No records found';
		    };			    
		    $scope.getRecords(true);
			/**
			 * Function is used to select current tab,and set it to scope property
			 * 
			 * @param string tab
			 * @return string
			 */
			$scope.selectTab = function(tab) {
				$scope.filters.tab = tab;	
				$scope.tabSelected = tab;
				$scope.showRecords = false;				
				$scope.gridLoadingBar = true;				
				$scope.getRecords(true);
			};		
		
			/**
			 * Function is used to include table body
			 * 
			 * @return void
			 */
			$scope.buildTableBody = function() {
				return $scope.request.getTemplateUrl($scope.moduleName) + '/grid';
			}
			/**
			 * Function is used to delete records
			 * 
			 * @return void
			 */
			$scope.deleteRecords = function() {
				if($scope.selectedCheckbox.length > 0 ) {
					$scope.confirmationDeleteBox = true;
					$scope.alertBox = false;
					$scope.deleteParams = $scope.selectedCheckbox;
				}
				else {
					$scope.confirmationDeleteBox = false;
					$scope.alertBox = true;
				}
			}
			/**
			 * Function is used to delete single record
			 * 
			 * @param int id
			 * @return void
			 */
			$scope.deleteSingleRecord = function(id) {
				$scope.selectedCheckbox = [id];
				$scope.alertBox = false;
				$scope.confirmationDeleteBox = true;
			};
			/**
			 * Function is used to add\remove record id to selectedCheckbox variable to delete records
			 * 
			 * @param int id
			 * @return void
			 */
			$scope.addSelectedCheckBox = function(id) {
				var index = $scope.selectedCheckbox.indexOf(id);

				if(index != -1 ) {
					$scope.selectedCheckbox.splice(index,1);
				} else {
					$scope.selectedCheckbox.push(id);
				}
			};
			/**
			 * Function is used confirm the delete action
			 * 
			 * @return void
			 */			
			$scope.confirmDelete = function() {
				if($scope.selectedCheckbox.length > 0 ) {
					gridObj.deleteRecords($scope,$rootScope);
					$scope.confirmationDeleteBox = false;
					$scope.alertBox = false;
				}
				else {
					$scope.confirmationDeleteBox = false;
					$scope.alertBox = false;
				}
			};
			/**
			 * Function is used cancel the proceeded delete action
			 * 
			 * @return void
			 */			
			$scope.cancelDelete = function(){
				$scope.confirmationDeleteBox = false;
				$scope.alertBox = false;
			};		
			/**
			 * Function is used to show list view with required number of rows
			 * 
			 * @param object element
			 * @return void
			 */
			$scope.setNumerOfRecordPerPage = function(element) {
				if(element.selectedRowsPerPage < $scope.totalRecords){
					var numerOfPages = Math.ceil($scope.totalRecords/element.selectedRowsPerPage)
					
					if(numerOfPages < $scope.currentPage){
						$scope.currentPage = numerOfPages;
					} 
				} else {
					$scope.currentPage = 1;
				}

				$scope.rowsPerPage = element.selectedRowsPerPage;
				$scope.selectedRowsPerPage = element.selectedRowsPerPage;
				
				
				$scope.showRecords = false;
				$scope.gridLoadingBar = true;
				$scope.records = '';
				$scope.getRecords(true);
			};
			/**
			 * Function is used to call getRecords method with startOffset and endOffset to get required set or records
			 * 
			 * @param int pageNumber
			 * @return void
			 */
			$scope.getPageRecord = function(pageNumber) {
				if(!pageNumber || $scope.rowsPerPage > $scope.totalRecords) {
					return false;
				}
				$scope.showRecords = false;
				$scope.gridLoadingBar = true;
				$scope.currentPage = pageNumber;
				$scope.getRecords(true);
			};
			/**
			 * Function is used to format the date
			 * 
			 * @param string date
			 * @param string format
			 * @return void
			 */
			$scope.formatDate = function(date,format) {
				var formattedDate = date;

				if(!angular.isDefined(format)){
					format = 'MMM d, yyyy';
				}

				try{
					formattedDate = $filter('date')(new Date(date), format);
				}catch(error){}

				return formattedDate;
			};
			/**
			 * Function is used to call listFieldSorting method to sort field
			 * 
			 * @param object event
			 * @param string field
			 * @return void
			 */
			$scope.fieldOrder = function(event,field) {	
				if($scope.filterRecords == false ) {
					return false;
				}
				$scope.noRecords = false;
				gridObj.listFieldSorting($scope, event, field);
			}
			/**
			 * Function is used to toggle select all check box when user click each record instead of select all checkbox
			 * 
			 * @param int id
			 * @return void
			 */
			$scope.selectCheckBox = function(id) {
				var totalCheckBoxLength = angular.element('.row-checkbox').length;
				var checkBoxLength = 0;
				angular.element('.row-checkbox').each(function(){
					if(angular.element(this).is(':checked')) {
						checkBoxLength++;
					}
				});

				if(checkBoxLength == totalCheckBoxLength ) {
					angular.element('#selectall').prop('checked',true);
				}
				else {
					angular.element('#selectall').prop('checked',false);
				}

				$scope.addSelectedCheckBox(id);

				if($scope.selectedCheckbox.length > 0){
					angular.element('.options-drop').show();			
				} else {
					angular.element('.options-drop').hide();
				}
			};
			/**
			 * Function used to call search to get searched recoreds
			 * 
			 */
			$document.bind('keyup', function(e) {
				if(e.keyCode == 13 && !angular.equals({}, $scope.filters)) {
					$scope.doGridSearch();
				}
				if(e.keyCode == 27) {
					if(angular.element("#deleteModal").is(":visible") == true) {
						angular.element('#deleteModal').modal('hide');
					}
				}
			});
			/**
			 * Function used to do the grid search
			 * 
			 * @return void
			 */
			$scope.doGridSearch = function() {
				$scope.showRecords = false;
				$scope.gridLoadingBar = true;
				$scope.getRecords(true);
			};
			/**
			 * Function used to reset grid
			 * 
			 * @return void
			 */			
			$scope.gridReset = function() {
				$scope.filters = {};
				$scope.$emit('gridReset');
				$scope.getRecords(true);
				$scope.filters.status = 'All';
			}			
			/**
			 * Function is used to toggle select all check box
			 * 
			 * @return void
			 */
			$scope.selectAll = function() {
				if(angular.element('#selectall').prop('checked')) {
					angular.element('.row-checkbox').each(function(){
						if(angular.element(this).is(':checked') === false ) {
							angular.element(this).prop('checked',true);
							$scope.addSelectedCheckBox((angular.element(this).attr('value')));
						}
					});
					angular.element('.options-drop').show();
				}
				else {
					angular.element('.row-checkbox').each(function(){
						angular.element(this).prop('checked',false);
						$scope.addSelectedCheckBox((angular.element(this).attr('value')));
					});
					angular.element('.options-drop').hide();
				}
			};										
		}],
		templateUrl : function(element,attr) {
			if(
				attr.hasOwnProperty('templateName') && attr.templateName != ''		
				|| (attr.hasOwnProperty('moduleName') && attr.moduleName != '')
			) {
				var path = 'grid/'+(attr.templateName ? attr.templateName : attr.moduleName);
				return request.getTemplateUrl(path);
			}
		}
	};
}];

window.gridView  = gridView;