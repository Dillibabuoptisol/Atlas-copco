'use strict';

var grid = angular.module('grid',[]);

/**
* Factory which Handle requests
*/
grid.factory('requestFactory',requestFactory);

/**
* notification directive to handle error and success messages
*/
grid.directive('notification',notificationDirective);

/**
* Directive to intialized tablesaw
*/
grid.directive('onFinishRender',['$timeout',function($timeout){
	return {
		restrict: 'A',
		link    : function(scope, element, attrs){
			if (scope.$last === true) {
				$timeout(function(){$( document ).trigger( "enhance.tablesaw" );},1000);				
			}
		}
	}
}]);

/**
* Directive to intialized tablesaw
*/
grid.directive('onFinishRenderedRecords',['$timeout',function($timeout){
	return {
		restrict: 'A',
		link    : function(scope){
			if (scope.$last === true && angular.isUndefined($('table.tablesaw').data('table'))) {
				$('.tablesaw-advance').remove();
				$('.tablesaw-toolbar').remove();
				$timeout(function(){$( document ).trigger( "enhance.tablesaw" );},1000);				
			}
		}
	}
}]);

/**
* Directive to intialized Date Range Picker
*/
grid.directive('dateRange',['$timeout',function($timeout){
    return {
        restrict: 'A',
        link    : function(scope, element, attrs){
          $timeout(function(){
                $(element).daterangepicker({autoUpdateInput: false});
                $(element).on('apply.daterangepicker', function(ev, picker) {
                	var value = picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY');
                    $(element).val(value);
                    
                    $timeout(function(){
                    	var filterNgModelName = angular.isString(attrs.ngModel) ? attrs.ngModel.split(".") : null;
                    	
                    	if(angular.isArray(filterNgModelName) && filterNgModelName.length > 1){
                    		scope.filters[filterNgModelName[1]] = value
                    	}

                    	if(!scope.$$phase){
                    		scope.$apply();
                    	}
                		scope.doGridSearch();
                    },100);
                });
                $(element).on('cancel.daterangepicker', function(ev, picker) {
                	  //do something, like clearing an input
                	  $(element).val('');
                });
            },1000);
        }
    }
}]);

/**
* Directive to intialized bootstrap tooltips
*/
grid.directive('bootTooltip',function(){
	return {
		restrict: 'A',
		link    : function(scope, element, attrs){
			 try {
				$(element).tooltip(); 
			 } catch(error){}
		}
	}
});

/**
* Define all grid directives
*/
if(angular.isObject(window.gridDirectives)){
	for(var directive in window.gridDirectives){
		if(angular.isArray(window.gridDirectives[directive]) || angular.isFunction(window.gridDirectives[directive])){
			grid.directive(directive,window.gridDirectives[directive]);
		}
	}
}
/**
* Define all grid controllers
*/
if(angular.isObject(window.gridControllers)){
	for(var controller in window.gridControllers){
		if(angular.isArray(window.gridControllers[controller]) || angular.isFunction(window.gridControllers[controller])){
			grid.controller(controller,window.gridControllers[controller]);
		}
	}
}

/**
* Define gridView directives
*/
grid.directive('gridView',window.gridView);

/**
* Manually bootstrap the Angular module here
*/
 angular.element(document).ready(function() {
    angular.bootstrap(document, ['grid']);
 });