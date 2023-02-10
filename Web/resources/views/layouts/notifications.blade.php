@if(isset($includeAngularNotification) && $includeAngularNotification)
<div data-notification >
    <div data-ng-if="$root.notification.currentItem">
        <div class="alert alert-success" data-ng-class="{
            'alert-success' : $root.notification.currentItem.isSuccess,
            'alert-info' : $root.notification.currentItem.isInfo,
            'alert-warning' : $root.notification.currentItem.isWarning,
            'alert-danger' : $root.notification.currentItem.isError
        }" role="alert"> 
            @{{$root.notification.currentItem.message}}
        </div>
    </div>
</div>
@endif