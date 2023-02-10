var validatorDirective = ['$timeout','$window',function($timeout,$window) {
      return {
        restrict: 'A',
        scope   : false,
        link: function(scope, element, attrs){
            var module = attrs.baseValidator;
           
            if(module.trim().length > 0){
              baseValidator.setCurrentModule(module).setFormByModule(element);
            }

            baseValidator.setScope(scope);
            
            element.find('textarea,select,input:not(input[type="hidden"],input[type="submit"],input[type="file"],input[data-ignore-validation])').each(function(){
            	
              angular.element(this).on('blur',function(){
                var element = this;
                
                var initValidator = function(){
                  var errors  = baseValidator.validateElement(element,module);
                    
                    if(scope.hasOwnProperty('errors')){
                      if(module.trim().length > 0){
                        scope.errors[module] = baseValidator.getFormattedErrorMessage(errors,scope.errors.hasOwnProperty(module) ? scope.errors[module] : {},element);
                      } else {
                        scope.errors = baseValidator.getFormattedErrorMessage(errors,scope.errors,element);
                      }

                      if (!scope.$$phase){
                        scope.$apply()
                      }
                    }                 
                } 
                
                if(element.dataset.hasOwnProperty('datepicker')){
                  $timeout(initValidator,200);
                } else {
                    initValidator();
                }
              });
            });
          }
      };
}];

window.validatorDirective = validatorDirective;