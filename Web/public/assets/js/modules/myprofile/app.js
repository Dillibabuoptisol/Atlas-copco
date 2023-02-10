'use strict';
var myProfile = angular.module('moverbee.myProfile', []);
myProfile.directive('notification', notificationDirective);
myProfile.directive('baseValidator', validatorDirective);
myProfile.factory('requestFactory', requestFactory);

myProfile.controller('MyprofileController', ['$window', '$scope', 'requestFactory', '$rootScope' , '$timeout', function($window, scope, requestFactory, $rootScope, $timeout) {
    requestFactory.setThisArgument(this);
    this.myProfile = {};
    scope.errors = {};
    
    /**
     * Initialize upload handler will 
     * required options for driver
     */
    $timeout(function(){
    	(new uploadHandler).initate({
            file      : 'picture-user',
            previewer : 'user-profile-image',
            progress  : 'user-progress',
            url       : requestFactory.getTemplateUrl('api/upload',{service : 'myprofile'}),
            afterUpload : function(response){
            	self.myProfile.uploadedImage=response.info;
            }
        });
    }, 300);
    
    /**
     * Method to get the rules set for the delivery slot form
     */
    this.fetchAddformRules = function() {
        requestFactory.get(requestFactory.getUrl('myprofile/create'), function(response) {
        	this.roles = response.userRoles;
            this.myProfile.is_active = 1;
            this.myProfile.gender = "male";
            baseValidator.setRules(response.rules);
        }, function() {});
    };
    /**
     * Method to save the add form data into delivery_slots table
     */
    this.save = function(event) {
    	if(angular.isDefined(self.myProfile.uploadedImage)) {
    		this.myProfile.profile_image = self.myProfile.uploadedImage;
    	}
        if (baseValidator.validateAngularForm(event.target, scope)) {
            this.myProfile.id = this.id
            requestFactory.post(requestFactory.getUrl('myprofile'), this.myProfile, function(response) {
                $window.location = requestFactory.getTemplateUrl('myprofile/edit/'+this.myProfile.id);
                $rootScope.notification.add({isSuccess : true,message : response.message}).showLater();
            }, this.fillError);
        }
    };
    /**
     * Method to handle the error message.
     */
    this.fillError = function(response) {
        if (response.status == 422 && response.data.hasOwnProperty('messages')) {
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
    this.fetchmyProfileSingleInfo = function(id) {
        this.id = id;
        requestFactory.get(requestFactory.getUrl('myprofile/' + this.id + '/edit'), function(response) {
            this.myProfile = response.myProfileSingleInfo;
        	this.roles = response.userRoles;
            this.myProfile.is_active = response.myProfileSingleInfo.is_active;
            this.myProfile.user_role = response.myProfileSingleInfo.user_role_id;
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
    angular.bootstrap(document, ['moverbee.myProfile']);
});