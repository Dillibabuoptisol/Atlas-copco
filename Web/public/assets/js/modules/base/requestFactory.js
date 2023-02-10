'use strict';

var requestFactory = ['$http','$rootScope','$filter','$window',function(http,rootScope,$filter,$window){
  var self = this;
  
  var requestHandler = {
   /**
    * object property to object this reference
    * @var object
    */    
    self : null,
   /**
    * object property to hold base api url
    * @var string
    */    
    baseApiUrl : null,    
    /**
     * object property to hold current requested service
     * @var string
     */    
    service : null, 
    /**
     * object property to hold service api url
     * @var object
     */    
    serviceApiUrl : {},    
   /**
    * object property to hold base Template url
    * @var string
    */    
    baseTemplateUrl : null,
   /**
    * object property to hold default date format
    * @var string
    */    
    baseDateFormat : 'dd-MM-yyyy',
   /**
    * object property to hold default datetime format
    * @var string
    */    
    baseDateTimeFormat : 'dd-MM-yyyy HH:mm:ss',         
   /**
    * object property to various request headers
    * @var object
    */    
    headers : {},
   /**
    * object property to this argument
    * @var object
    */    
    thisArgument : self,    
   /**
    * object property method to set the headers and base url from meta tags
    *
    * @return object
    */    
    boot : function(){
      for(var i = 0, meta; meta = document.getElementsByTagName('meta')[i]; i++){
        if(meta.name == 'csrf-token'){
          this.headers['X-CSRF-TOKEN'] = meta.content;
        }
        if(meta.name == 'base-api-url'){
          this.baseApiUrl = meta.content;
        }
        if(meta.dataset.hasOwnProperty('service') && angular.isString(meta.dataset.service)){
            this.serviceApiUrl[meta.dataset.service] = meta.content;
        }
        if(meta.name == 'base-template-url'){
          this.baseTemplateUrl = meta.content;
        }

        if(meta.name == 'public-access-token'){
            this.headers['X-PUBLIC-ACCESS-TOKEN'] = meta.content;
        }

        if(meta.name == 'user-id'){
            this.headers['X-USER-ID'] = meta.content;
        }

        if(meta.name == 'access-token'){
            this.headers['X-ACCESS-TOKEN'] = meta.content;
        }
      }

      this.headers['X-WEB-SERVICE'] = true;
      this.headers['Accept'] = 'application/json';

      return this;

    }, 
   /**
    * object property method to get available headers
    *
    * @return headers
    */                  
    getHeaders: function() {
      return this.headers;
    },
   /**
    * object property method to get base api url
    *
    * @return string
    */    
    getBaseApiUrl: function() {
      return this.baseApiUrl;
    },
    /**
     * set current request service
     *
     * @param string service
     * @return requestFactory
     */    
     currentService: function(service) {
       this.service = service;	 
    	 
       return this;
     },    
    /**
     * object property method to get service api url
     *
     * @return string
     */    
     getServiceApiUrl: function() {
       return (this.service && angular.isDefined(this.serviceApiUrl[this.service])) 
       				? this.serviceApiUrl[this.service] : '/';
     },    
   /**
    * object property method to get base template url
    *
    * @return string
    */      
    getBaseTemplateUrl: function() {
      return this.baseTemplateUrl;
    },
    /**
    * object property method to get auth userid
    *
    * @return string
    */  
    getAuthUserId: function() {
	  return this.headers['X-USER-ID'];
	},
    /**
    * object property method to get auth userid
    *
    * @return string
    */ 
	getDateFormat: function() {
      return this.baseDateFormat;
    },
    /**
    * object property method to get datetime format
    *
    * @return string
    */ 
    getDateTimeFormat: function() {
	  return this.baseDateTimeFormat;
	},
    /**
    * object property method for get request
    * @param url
    * @param successCallback
    * @param errorCallback
    * @return string
    */ 
    get: function(url,successCallback,errorCallback) {
        this.request({
            method  : 'GET',
            url     : url,
            headers : this.getHeaders(),
        },successCallback,errorCallback);
    }, 
    /**
    * object property method for getTemplate request
    *
    * @param url
    * @param successCallback
    * @param errorCallback
    * @return string
    */ 
    getTemplate: function(url,successCallback,errorCallback) {
        this.request({
            method  : 'GET',
            url     : url,
        },successCallback,errorCallback);
    },
    /**
    * object property method for post request
    *
    * @param url
    * @param data
    * @param successCallback
    * @param errorCallback
    * @return string
    */ 
    post: function(url,data,successCallback,errorCallback) {
        this.request({
            method  : 'POST',
            url     : url,
            headers : this.getHeaders(),
            data    : data
        },successCallback,errorCallback);
    },
    /**
    * object property method for delete request
    *
    * @param url
    * @param data
    * @param successCallback
    * @param errorCallback
    * @return string
    */
    delete: function(url,data,successCallback,errorCallback) {
        this.request({
            method  : 'DELETE',
            url     : url,
            headers : this.getHeaders(),
            data    : data
        },successCallback,errorCallback);
    },
    /**
    * object property method for request
    *
    * @param config
    * @param successCallback
    * @param errorCallback
    * @return string
    */
    request: function(config,successCallback,errorCallback) {
        http(config).then(this.successCallback(successCallback),this.errorCallback(errorCallback));
    },
    /**
    * object property method for set this argument
    *
    * @param thisArgument
    * @return string
    */
    setThisArgument: function(thisArgument) {
        this.thisArgument = thisArgument;

        return this;
    },
    /**
    * object property method for callback the sucess method
    * @param callback
    * @return string
    */
    successCallback: function(callback) {
        return function(response){
            if(typeof callback == 'function'){
                callback.call(requestHandler.thisArgument,response.data);
            }
        }
    },
    /**
    * object property method for callback the error method
    *
    * @param callback
    * @return string
    */
    errorCallback: function(callback) {
        return function(response){
            if(response.status == 403 && angular.isDefined(response.data.accessFailure)){
                if(angular.isDefined(response.data.redirectTo)){
                    $window.location = response.data.redirectTo;
                } else if(angular.isDefined(response.data.message)){
                    console.error(message);
                }
            }

            if(typeof callback == 'function'){
                callback.call(requestHandler.thisArgument,response);
            }
        }
    },
    /**
    * object property method for build the query
    *
    * @param queryParams
    * @return string
    */
    buildQueryParams: function(queryParams) {
        var params      = false;
        var queryLength = Object.keys(queryParams).length;
        var i = 1;


        for(var iter in queryParams) {
          if(typeof queryParams[iter] != 'undefined'){
            if(!params){
              params = '?';
            }
            if(angular.isObject(queryParams[iter])){
                for(var queryParamIter in queryParams[iter]) {
                    params += iter+'['+queryParamIter+']='+queryParams[iter][queryParamIter];
                    params += '&';
                }
            } else {
                params += iter+'='+queryParams[iter];
            }

            if(i < queryLength){
                params += '&';
            }
            
            i++;
          }
        }

        return params;
    },
    /**
    * object property method for get the url
    *
    * @param path
    * @param queryParams
    * @return string
    */
    getUrl: function(path,queryParams) {
    	var url = this.service ? this.getServiceApiUrl()+'/'+path : this.getBaseApiUrl()+'/'+path;

        return (queryParams) ? url+this.buildQueryParams(queryParams) : url;
    },
    /**
    * object property method for get the template url
    *
    * @param path
    * @param queryParams
    * @return string
    */
    getTemplateUrl: function(path,queryParams){
        var url = this.getBaseTemplateUrl()+'/'+path;

        return (queryParams) ? url+this.buildQueryParams(queryParams) : url;
    },
    /**
    * object property method for get the active session
    *
    * @return string
    */
    isActiveSession: function(){
        var userId = this.getAuthUserId();

        return angular.isDefined(userId) && userId != null;
    }, 
    /**
    * object property method for get the info url
    *
    * @return string
    */
    getInfoUrl: function(){
        var path  = 'info';
        var model = this.getModelId();

        if(model){
          path = path+'/'+this.getModelId();
        }

        return this.getUrl(path,{query : this.getQueryParam()});
    },
    /**
    * object property method to find the property is mobile or not
    *
    * @return string
    */
    isMobile: function(){
        return (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || window.innerWidth <= 800);
    },
    /**
     * Function to show and hide the loader image.
     */
    toggleLoader: function(){
    	var loader = angular.element(document.getElementById('preloader'));
	    if(loader.css('display') == 'none'){
	       loader.find('#status').css('display','block');
	       loader.css('display','block');
	    } else {
	       loader.find('#status').css('display','none');
	       loader.css('display','none');
	    }
    },
  };


  return requestHandler.boot();
}];