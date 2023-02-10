'use strict';

var dateRangeExport = ['$timeout',function($timeout){
    return {
        restrict: 'A',
        link    : function(scope, element, attrs){
          $timeout(function(){
                $(element).daterangepicker({autoUpdateInput: false, maxDate: new Date()});
                $(element).on('apply.daterangepicker', function(ev, picker) {
                	var value = picker.startDate.format('DD-MM-YYYY') + ' ' + picker.endDate.format('DD-MM-YYYY');
                    $(element).val(value);
                    $timeout(function(){
                    	var filterNgModelName = angular.isString(attrs.ngModel) ? attrs.ngModel.split(".") : null;
                    	
                    	if(angular.isArray(filterNgModelName) && filterNgModelName.length > 1){
                    		scope.xldates[filterNgModelName[1]] = value
                    	}
                        if(!scope.$$phase){
                    		scope.$apply();
                    	}
                        scope.exportDateRange(value); 
                        $('#exportclk').modal('hide');
                    },100);
                });
                $(element).on('cancel.daterangepicker', function(ev, picker) {
                	$(element).val('');
                });
            },1000);
        }
    }
}]

var Export = ['$window', '$scope', 'requestFactory', '$timeout', '$filter','$rootScope','$interval', function($window, scope, requestFactory, $timeout, $filter,$rootScope,$interval) {
    var self = this;
    scope.xldates={};
    scope.rvformId = '';
	  scope.exportDateRange = function(range) {
        if (range) {
         var ranges = range.split(" ");
         var token ={};
         token.first=ranges[0];
         token.last=ranges[1];
         var url = document.URL;
         var shortUrl=url.substring(0,url.lastIndexOf("/"));
	     window.location = shortUrl+'/exportrvform' + requestFactory.buildQueryParams(token);
	    }
    else{
        $rootScope.notification.add({isWarning : true,message : 'Export date range is empty'}).showNow($rootScope);
    }
}

scope.setDeleteID = function(id){
     scope.rvformId = id;
     console.log(scope.rvformId);
}

scope.deleteRecord = function(){
    requestFactory.toggleLoader();
        requestFactory.get(requestFactory.getUrl('rvdelete/'+scope.rvformId ), function(response) {
             $window.location = requestFactory.getTemplateUrl('receiptvoucher');
             $rootScope.notification.add({isSuccess : true,message : response.message}).showLater();
        }, function() {});
     console.log(scope.rvformId);
}
}];
/**
 * Manually bootstrap the Angular module here
 */
if(angular.isObject(window.gridControllers)){
    window.gridControllers.Export = Export;   
} else {
    window.gridControllers = {Export: Export};   
}
/**
 * Manually bootstrap the Angular module here
 */
if(angular.isObject(window.gridDirectives)){
    window.gridDirectives.dateRangeExport = dateRangeExport;   
} else {
    window.gridDirectives = {dateRangeExport: dateRangeExport};   
}