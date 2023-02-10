'use strict';
var email = angular.module('moverbee.email', ['ui.tinymce']);
email.directive('notification', notificationDirective);
email.factory('requestFactory', requestFactory);
email.directive('baseValidator', validatorDirective);
email.factory('requestFactory', requestFactory);

email.controller('EmailController', ['$window', '$scope', 'requestFactory', '$rootScope', function($window, scope, requestFactory, $rootScope) {
    requestFactory.setThisArgument(this).currentService('admin');
    this.email = {};
    scope.errors = {};
    
    scope.tinymceOptions = {
    	    plugins: 'link image code',
    	    height: 300,
    	    toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | code'
    	  };
    
    /**
     * Method to get the rules for the add form
     */
    this.fetchRules = function() {
        requestFactory.get(requestFactory.getUrl('emailtemplate/create'), function(response) {
        	baseValidator.setRules(response.rules);
        }, function() {});
    };
    /**
     * Method to save the add form data
     */
    this.save = function(event) {
        if (baseValidator.validateAngularForm(event.target, scope)) {
            this.email.id = this.id
            this.email.user_id = 1;
            this.email.is_active = 1;
            if(angular.isDefined(self.email.body)) {
            	this.email.body = self.email.body;
            }
            requestFactory.post(requestFactory.getUrl('emailtemplate'), this.email, function(response) {
                $window.location = requestFactory.getTemplateUrl('email');
                $rootScope.notification.add({isSuccess : true,message : response.message}).showLater();
            }, this.fillError);
        }
    };
    /**
     * Method to handle the error message.
     */
    this.fillError = function(response) {
        this.isDisabled = false;
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
     * Method to get the single record data for the zones
     *
     * @param id, record id
     * @returns object
     */
    this.fetchSingleInfo = function(id) {
        this.id = id;
        requestFactory.get(requestFactory.currentService('admin').getUrl('emailtemplate/' + this.id + '/edit'), function(response) {
        	this.email = response.emailSingleInfo;
        	if(this.email.body){
        		scope.descriptionElement.editor.setValue(this.email.body);
      	 	}
        	baseValidator.setRules(response.rules);
        }, function() {});
    };
    
    $(document).ready(function(){
		  scope.descriptionElement = $('#wysiwyg').wysihtml5({
			  color  : true,
			  html   : true,
			  events : {
				  blur : function() {
					  self.email.body = this.textarea.element.value;
				  }
			  },
		  }).data('wysihtml5');
	  });
    
}]);
/**
 * Manually bootstrap the Angular module here
 */
angular.element(document).ready(function() {
    angular.bootstrap(document, ['moverbee.email']);
});