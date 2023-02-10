<div class="col-md-12 bottom" data-ng-if="records" >
    <div class="col-md-4 default"> 
        <span>{{trans(MESSAGE_SHOW_ENTRIES)}}</span> 
        @include('layouts.rowperpage')
    </div>
    <ul class="angular_pagination pagination pagination-split  pull-right" >
        <li>
            <span data-ng-click="getPageRecord(link.pageNumber)" class="pageLink" data-ng-class="{current:link.current}" data-ng-repeat="link in links">@{{link.value}}</span>
        </li>
    </ul>
</div>
@if(!isset($withOutDeleteModelHtml))               
    <div class="modal fade" id="deleteModal"  data-role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    @if(isset($module_name))
                        <h4 class="modal-title"> Delete {{$module_name}} </h4>
                    @else
                        <h4 class="modal-title"> {{trans(MESSAGE_DELETE_RECORDS)}} </h4>
                    @endif
                </div>
                <div class="modal-body">
                    <div data-ng-show="confirmationDeleteBox">
                        <p>{{trans(MESSAGE_DELETE_SELECTED_RECORDS_CONFRIMATION)}}</p>
                    </div>
                </div>
                <div class="clearfix modal-footer">
                    <span data-ng-click="cancelDelete()" class="btn btn-danger pull-right"
                        data-dismiss="modal">{{trans(MESSAGE_CANCEL)}}</span>
                    <span data-ng-click="confirmDelete()" class="btn btn-primary pull-right mr10"
                        data-dismiss="modal">{{trans(MESSAGE_CONFIRM)}}</span>
                 </div>
            </div>
        </div>
    </div>
@endif   