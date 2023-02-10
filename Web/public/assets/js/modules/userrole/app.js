'use strict';
var userRole = angular.module('moverbee.userrole', ['btorfs.multiselect']);
userRole.directive('baseValidator', validatorDirective);
userRole.factory('requestFactory', requestFactory);
userRole.directive('notification', notificationDirective);
userRole.controller('RoleController', ['$window', '$scope', 'requestFactory', '$rootScope', function($window, scope, requestFactory, $rootScope) {
    requestFactory.setThisArgument(this);
    this.userRole = {};
    scope.errors = {};
    this.userRole.is_active = "1";
    this.permissionsMsg = false;
    scope.options = ['Create', 'View', 'Update', 'Delete'];

    this.fetchInfo = function(query) {
        requestFactory.get(requestFactory.getUrl('userrole/create'), function(response) {
            this.permissions = response.permission;
            this.userRole.status = 1;
            baseValidator.setRules(response.rules);
        }, function() {});
    };

    this.save = function($event) {

        if (baseValidator.validateAngularForm($event.target, scope)) {
            if (angular.isUndefined(this.userRole.permissions) || this.userRole.permissions == "") {
                this.permissionsMsg = true;
                return false;
            }
            requestFactory.post(requestFactory.getUrl('userrole'), this.userRole, function(response) {
                this.permissionsMsg = false;
                $window.location = requestFactory.getTemplateUrl('userrole');
                $rootScope.notification.add({isSuccess : true,message : response.message}).showLater();
            }, this.fillError);
        }
    };

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
     * Method to fetch the data of a single delivery type.
     *
     * @param int id, the record id.
     */
    this.fetchUserRoleSingleInfo = function(id) {
        this.id = id;
        requestFactory.get(requestFactory.getUrl('userrole/' + this.id + '/edit'), function(response) {
            this.userRole = response.adminRoleSingleInfo;
            this.getPermissions = JSON.parse(response.adminRoleSingleInfo.permissions);
            this.selectedPermission = [];
            angular.forEach(this.getPermissions, function(value, key) {
            	  if(value === true){
            		  this.push(key);
            	  }
            	}, this.selectedPermission);
            this.userRole.permissions = this.selectedPermission;
            this.userRole.status = response.adminRoleSingleInfo.is_active;
            baseValidator.setRules(response.rules);
        }, function() {});
    };
}]);

/**
 * Manually bootstrap the Angular module here
 */
angular.element(document).ready(function() {
    angular.bootstrap(document, ['moverbee.userrole']);
});