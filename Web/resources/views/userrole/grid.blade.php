	<div class="mainpanel-template s_table">
		<div class="header-filter clearfix">
			<h3>{{trans('user.manage_roles')}}</h3>
			<div class="filter">
				<a href="{{url('userrole/add')}}" class="create-new">{{trans('user.add_roles')}}</a>
			</div>
		</div>
		
		    <!-- Tab panes -->
		   
	            <div class="table-responsive normal-table">
	                <div id="table_loader" class="table_loader_container ng-hide" data-ng-show="tableLoader">
	                          <div class="table_loader">
	                           <div class="loader"></div>
	                          </div>
	                        </div>
	                <table class="table tablesaw" data-tablesaw-mode="columntoggle">
	                    <thead class="header">
	                        <tr>
	                            <th>{{trans('general.sno')}}</th>
	                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">{{trans('user.thead.name')}}</th>
	                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">{{trans('user.thead.created_date')}}</th>
	                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">{{trans('general.status')}}</th>
	                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">{{trans('general.action')}}</th>
	                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist"></th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                        <tr class="search-row">
	                        <td></td>
	                            <td>
	                                <div class="tooltip1">
	                                    <input type="text" class="form-control" data-ng-model="filters.name">
	                                    <span class="tooltiptext">{{trans('user.filter.name')}}</span>
	                                </div>
	                            </td>
	                            <td>
	                            </td>
	                              <td>
	                              <div class="tooltip1">
	                                  <select class="form-control select" data-ng-init="filters.status='All'" data-ng-model="filters.status" ng-change="getRecords(true)">
	                                      <option data-ng-value="All">{{trans('general.all')}}</option>
	                                      <option data-ng-value="1">{{trans('general.active')}}</option>
	                                      <option data-ng-value="0">{{trans('general.inactive')}}</option>
	                                  </select>
	                                  <span class="tooltiptext">Filter by Status</span>
	                              </div>
	                          </td>
	                          <td><button type="button" data-ng-click="doGridSearch()"
						        class="btn search warning" data-boot-tooltip="true"
						        data-toggle="tooltip"
						        data-original-title="{{trans('general.search')}}">
						        <i class="fa fa-search"></i></button>
						        <button type="button" class="danger product_list_reset_btn btn" name="reset" data-ng-click="gridReset()" value="{{trans('general.reset')}}" data-boot-tooltip="true" data-toggle="tooltip" data-original-title="{{trans('general.reset')}}"><i class="fa fa-refresh"></i></button>
						        </td>
	                            <td></td>
	                        </tr>
	                        <tr data-ng-if="noRecords">
	                            <td colspan="6" class="no-data">{{trans('messages.empty_record')}}</td>
	                        </tr>
	                        <tr data-ng-if="showRecords" data-on-finish-rendered-records data-on-finish-rendered data-ng-repeat="record in records track by $index">
	                            <td>@{{$index+1}}</td>
	                            <td>@{{record.name}}</td>
	                            <td>@{{record.created_at}}</td>
	                            <td data-ng-if="record.is_active== 1" ><label class="active">{{trans('general.active')}}</label></td>
	                            <td data-ng-if="record.is_active== 0" > <label class="inactive">{{trans('general.inactive')}}</label></td>
	                            <td class="more-function">
									<div class="more">
										<i class="icon-two-dots"></i>
										<ul class="more-dropdown">
											<li><a data-ng-href="{{url('userrole/edit').'/'}}@{{record.id}}"> <i class="icon-edit sprite"></i> {{trans('general.edit')}}
											</a></li>
										</ul>
									</div>
								</td>
								<td></td>
	                        </tr>
	                    </tbody>
	                </table>
	            </div>
	         <div class="custom-pagination clearfix">
	            @include('layouts.pagination',['module_name'=>'Admin User Role'])
	         </div>
	</div>
