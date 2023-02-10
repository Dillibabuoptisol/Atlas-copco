'use strict';
var lg = $("#lightgallery");  
var selectedDate = '';
var ReceiptVoucher = angular.module('ReceiptVoucher', []);
ReceiptVoucher.directive('notification', notificationDirective);
ReceiptVoucher.directive('baseValidator', validatorDirective);
ReceiptVoucher.factory('requestFactory', requestFactory);

ReceiptVoucher.controller('RVUserController', ['$window', '$scope', 'requestFactory', '$rootScope' , '$timeout', function($window, scope, requestFactory, $rootScope, $timeout) {
    requestFactory.setThisArgument(this);
    this.receiptVoucher = {};
    this.invoiceDetails = {};
    this.invoiceCount = '';
    this.loadMore = false; 
    this.invoiceImages = false; 
    scope.errors = {};
    
    
    /**
     * Method to get the rules set for the delivery slot form
     */
    this.fetchAddformRules = function() {
        requestFactory.get(requestFactory.getUrl('receiptvoucher/create'), function(response) {
            this.ReceiptVoucher.is_active = 1;
            baseValidator.setRules(response.rules);
        }, function() {});
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
    this.fetchReceiptVoucherSingleInfo = function(id) {
        this.id = id;
        requestFactory.get(requestFactory.getUrl('receiptvoucher/' + this.id + '/edit'), function(response) {
            this.receiptVoucher = response.rvDetails;
            var invoices = response.rvDetails.rv_invoice;
            this.invoiceCount = response.rvDetails.rv_invoice.length;
            this.invoiceDetails = response.rvDetails.rv_invoice;
                for(var i = 0; i < invoices.length; i++) {
                if (invoices[i].invoice_image) {
                   this.invoiceImages= true;
                    break;
                }
            }
        }, function() {});
    };
    
    this.saveData = function (){
         this.receiptVoucher.transaction_date=selectedDate
         requestFactory.post(requestFactory.getUrl('updaterv'), this.receiptVoucher, function(response) {
            $window.location = requestFactory.getTemplateUrl('receiptvoucher');
                $rootScope.notification.add({isSuccess : true,message : response.message}).showLater();
            }, this.fillError);
    }

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
        /**
     * Method to get the all image record data
     *
     * @param rvId
     * @returns object
     */

    this.showAllImages= function(rvId){
            requestFactory.get(requestFactory.getUrl('receiptimages/' + rvId), function(response) {
             this.invoiceDetails=response;
             this.loadMore = false;
        }, function() {});
    }
}]);


ReceiptVoucher.directive('invoice', function() {
        function link(scope, element, attrs) {
            if (scope.$last){
                lg.lightGallery({zoom:'true',fullScreen:'true'});
            }
    } 
return link;
        });

var transactionDate = ['$timeout',function($timeout){
    return {
        restrict: 'A',
        link    : function(scope, element, attrs){
          $timeout(function(){
                $(element).daterangepicker({autoUpdateInput: false,singleDatePicker: true,showDropdowns: true, maxDate: new Date()});
                $(element).on('apply.daterangepicker', function(ev, picker) {
                    var value = picker.startDate.format('DD-MM-YYYY');
                    $(element).val(value);
                    selectedDate = value;
               });
                $(element).on('cancel.daterangepicker', function(ev, picker) {
                    $(element).val('');
                });
            },1000);
        }
    }
}]

ReceiptVoucher.directive('transactionDate', transactionDate);
/**
 * Manually bootstrap the Angular module here
 */
if(angular.isObject(window.gridControllers)){
    window.gridControllers.ReceiptVoucher = ReceiptVoucher;   
} else {
    window.gridControllers = {ReceiptVoucher: ReceiptVoucher};   
}
/**
 * Manually bootstrap the Angular module here
 */
if(angular.isObject(window.gridDirectives)){
    window.gridDirectives.transactionDate = transactionDate;   
} else {
    window.gridDirectives = {transactionDate: transactionDate};   
}

/**
 * Manually bootstrap the Angular module here
 */
angular.element(document).ready(function() {
    angular.bootstrap(document, ['ReceiptVoucher']);
});