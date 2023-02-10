var notificationObject = {
  /**
   * Object property hold the localStorage key
   *
   * @var string
   */
  localStorageKey : "_moverbeeNotification", 
  /**
   * Object property hold the notification flash time
   *
   * @var int
   */
  notificationFlashTime : 2000,    
  /**
   * Object property hold the item
   *
   * @var object
   */
  item : null,
  /**
   * Object property hold the current item
   *
   * @var object
   */
  currentItem : null,    
  /**
   * add a new notification
   * 
   * @param object item
   * @return this 
   */
  add : function(item){
    if(angular.isObject(item)){
      this.item = angular.extend({},{
        isSuccess:false,
        isInfo:false,
        isWarning:false,
        isError:false
      },item);
    }

    return this;
  },
  /**
   * show the notification as soon as this
   * this function is executed
   * 
   * @param object $rootScope
   * @return void 
   */
  showNow : function($rootScope){
    this.setCurrentItem(this.item);

    $rootScope.clearNotification();
  },
  /**
   * set the current notification item
   * 
   * @param mixed currentItem
   * @return this 
   */
  setCurrentItem : function(currentItem){
    this.currentItem = currentItem;

    return this;
  },
  /**
   * set the notification flash time
   * 
   * @param int notificationFlashTime
   * @return this 
   */
  setNotificationFlashTime : function(notificationFlashTime){
    this.notificationFlashTime = notificationFlashTime;

    return this;
  },    
  /**
   * show the notification after a page reloaded
   * by storing the item to local storage
   * 
   * @return this 
   */
  showLater : function(){
    window.localStorage.setItem(this.localStorageKey,window.JSON.stringify(this.item));

    return this;
  },
  /**
   * remove the notification item from local
   * storage if it localstorage contain it
   * 
   * @return void 
   */
  removeItemFromLocalStorage : function(){
    window.localStorage.removeItem(this.localStorageKey);

    return this;
  }, 
  /**
   * get the notification item from local
   * storage if it localstorage contain it
   * 
   * @return object 
   */
  getItemFromLocalStorage : function(){
    var item = window.localStorage.getItem(this.localStorageKey);

    if(typeof item == 'string' && typeof window.JSON == 'object'){
      try{
        item = window.JSON.parse(item);
      }catch(error){
        item = false;
      }
    }

    return item;
  },        
};


var notificationDirective = ['$rootScope','$window','$timeout',function($rootScope,$window,$timeout) {
      if(angular.isUndefined($rootScope.notification)){
        $rootScope.notification = notificationObject;

        $rootScope.clearNotification = function(){
          $timeout(function() {
            $rootScope.notification.currentItem = null;
            $rootScope.notification.removeItemFromLocalStorage();

            if(!$rootScope.$$phase){
              $rootScope.$apply();
            }
          }, $rootScope.notification.notificationFlashTime);
        };
      }

      return {
        restrict: 'A',
        scope   : false,
        link: function(){
          var notificationItem = $rootScope.notification.getItemFromLocalStorage();
          if(angular.isObject(notificationItem)){
            $rootScope.notification.add(notificationItem).setNotificationFlashTime(2000).showNow($rootScope);
          }
        }
      };
}];

window.notificationDirective = notificationDirective;