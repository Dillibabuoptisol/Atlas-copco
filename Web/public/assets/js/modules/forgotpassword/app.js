'use strict';
var forgotPwd = angular.module('forgotPassword', []);
forgotPwd.directive('notification', notificationDirective);
forgotPwd.directive('baseValidator', validatorDirective);
forgotPwd.factory('requestFactory', requestFactory);

forgotPwd.controller('forgotPasswordController', ['$window', '$scope',
 'requestFactory', '$rootScope', '$timeout','$location',
  function($window, scope, requestFactory, $rootScope, $timeout,$location,$route) {
    requestFactory.currentService('admin').setThisArgument(this);
    this.userData = {};
    scope.errors = {}; 

    this.forgotPassword = function(){
        console.log(this.userData);
        scope.errors = {};
        requestFactory.toggleLoader();
        requestFactory.post(requestFactory.getUrl('forgotpasswordlink'),this.userData,function(response) {
            requestFactory.toggleLoader();
            $rootScope.notification.add({isSuccess : true,message : 'Reset password link sent to your email'}).showNow($rootScope);
            setTimeout(function(){ $window.location = requestFactory.getTemplateUrl('login'); }, 2000);
        },this.fillError);   
    }
    this.resetPassword = function(){
        var url = $location.absUrl().split('?')[0];
        var lastString = url.substr(url.lastIndexOf('/') + 1);
        this.userData.token = lastString;
        scope.errors = {};
        requestFactory.toggleLoader();
        requestFactory.post(requestFactory.getUrl('resetPassword'),this.userData,function(response) {
            this.userData = {};
            scope.errors = {};
            $window.location = requestFactory.getTemplateUrl('login');
        },this.fillError);
    }
    /**
     * This method is used to populate the errors
     * 
     * @param {*} response 
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

}]);

/**
 * Manually bootstrap the Angular module here
 */
angular.element(document).ready(function() {
    angular.bootstrap(document, ['forgotPassword']);
});