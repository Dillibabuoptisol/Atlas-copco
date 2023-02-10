'use strict';
var Collector = angular.module('Collector', []);
Collector.directive('notification', notificationDirective);
Collector.directive('baseValidator', validatorDirective);
Collector.factory('requestFactory', requestFactory);

Collector.controller('CollectorUserController', ['$window', '$scope', 'requestFactory', '$rootScope' , '$timeout', function($window, scope, requestFactory, $rootScope, $timeout) {
    requestFactory.setThisArgument(this);
    this.Collector = {};
    scope.errors = {};
    
    /**
     * Initialize upload handler will 
     * required options for driver
     */
    
    $timeout(function() {
		(new uploadHandler).initate({
			file      : 'picture-user',
            previewer : 'user-profile-image',
            progress  : 'user-progress',
            url      : requestFactory.getTemplateUrl('api/upload',{service : 'collector'}),
            afterUpload : function(response){
              self.Collector.profile_image = response.info;
            }
        });
}, 2000);
    
    /**
     * Method to get the rules set for the delivery slot form
     */
    this.fetchAddformRules = function() {
        requestFactory.get(requestFactory.getUrl('collector/create'), function(response) {
            this.Collector.is_active = 1;
            baseValidator.setRules(response.rules);
        }, function() {});
    };
    /**
     * Method to save the add form data into delivery_slots table
     */
    this.save = function(event) {
    	if(angular.isDefined(self.Collector.profile_image)) {
    		this.Collector.profile_image = self.Collector.profile_image;
    	}
        if (baseValidator.validateAngularForm(event.target, scope)) {
            this.Collector.id = this.id
            requestFactory.toggleLoader();
            requestFactory.post(requestFactory.getUrl('collector'), this.Collector, function(response) {
                 $window.location = requestFactory.getTemplateUrl('collector');
                $rootScope.notification.add({isSuccess : true,message : response.message}).showLater();
            }, this.fillError);
        }
    };
    /**
     * Method to handle the error message.
     */
    this.fillError = function(response) {
        if (response.status == 422 && response.data.hasOwnProperty('messages')) {
            requestFactory.toggleLoader();
            angular.forEach(response.data.messages, function(message, key) {
                if (typeof message == 'object' && message.length > 0) {
                    scope.errors[key] = {
                        has: true,
                        message: message[0]
                    };
                }
            });
        }
    };
    /**
     * Method to get the sigle record data
     *
     * @param id, record id
     * @returns object
     */
    this.fetchCollectorSingleInfo = function(id) {

        this.id = id;
        requestFactory.get(requestFactory.getUrl('collector/' + this.id + '/edit'), function(response) {
            this.Collector = response.CollectorSingleInfo;
            this.Collector.is_active = response.CollectorSingleInfo.is_active;
            this.Collector.user_role = response.CollectorSingleInfo.user_role_id;
            baseValidator.setRules(response.rules);
        }, function() {});
    };
    
    /**
     * Trigger select file event on the requested 
     * input file element
     *
     * @param string elementId
     * @return void
     */
    this.triggerSelectFile = function(elementId) {
        angular.element(elementId).click();
    };
}]);
/**
 * Manually bootstrap the Angular module here
 */
angular.element(document).ready(function() {
    angular.bootstrap(document, ['Collector']);
});