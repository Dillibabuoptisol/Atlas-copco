	<div class="mainpanel-template">
		<div class="header-filter clearfix">
			<h3>{{trans('email.email_template')}}</h3>
			<div class="filter">
				<!-- <a href="{{url('email/add')}}" class="create-new">{{trans('user.add_new')}}</a> -->
			</div>
		</div>
            <div class="table-responsive normal-table">
                <div id="table_loader" class="table_loader_container ng-hide"
                 data-ng-show="tableLoader">
                 <div class="table_loader">
                  <div class="loader"></div>
                 </div>
                </div>
                <table class="table tablesaw" data-tablesaw-mode="columntoggle">
                    <thead class="header">
                    	<tr>
                            <th>{{trans('general.sno')}}</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">{{trans('email.name')}}</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Slug</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">{{trans('email.subject')}}</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">{{trans('general.action')}}</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="search-row">
                            <td></td>
                            <td>
                                <div class="tooltip1">
                                    <input type="text" class="form-control" data-ng-model="filters.name">
                                    <span class="tooltiptext">{{trans('email.name')}}</span>
                                </div>
                            </td>
                            <td></td>
                            <td></td>
                             <td class="whitespace-nowrap"><button type="button" data-ng-click="doGridSearch()"
						        class="btn search warning" data-boot-tooltip="true"
						        data-toggle="tooltip"
						        data-original-title="{{trans('general.search')}}">
						        <i class="fa fa-search"></i></button>
						        <button type="button" class="danger product_list_reset_btn btn" name="reset" data-ng-click="gridReset()" value="{{trans('general.reset')}}" data-boot-tooltip="true" data-toggle="tooltip" data-original-title="{{trans('general.reset')}}"><i class="fa fa-refresh"></i></button>
						        </td>
                            <td></td>
                        </tr>
                        <tr data-ng-if="noRecords">
                            <td colspan="7" class="no-data">{{trans('messages.empty_record')}}</td>
                        </tr>
                        <tr data-ng-if="showRecords" data-on-finish-rendered data-ng-repeat="record in records track by $index">
                            <td>@{{$index+1}}</td>
                            <td>@{{record.name}}</td>
                            <td>@{{record.slug}}</td>
                            <td>@{{record.subject}}</td>
                                        <td class="">
                <div class="tooltip1">
                    <a data-ng-href="{{url('email/edit').'/'}}@{{record.id}}"> <i class="icon-edit sprite"></i>
                    </a>
                    <span class="tooltiptext">{{trans('general.edit')}}</span>
                </div>
            </td>

                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
         <div class="custom-pagination clearfix">
         	@include('layouts.pagination',['module_name'=>'Email'])
         </div>
	</div>
		
