
<div class="">
	<div class="mainpanel-template">
		<div class="header-filter clearfix">
			<h3>Manage Collector</h3>
			<div class="filter">
				<a href="{{url('collector/add')}}" class="create-new">Add Collector</a>
			</div>
		</div>
		<!-- Tab panes -->
		<div class="table-responsive normal-table">
			<div id="table_loader" class="table_loader_container ng-hide" data-ng-show="tableLoader">
				<div class="table_loader">
					<div class="loader"></div>
				</div>
			</div>
			<table class="table">
				<thead class="header">
					<tr>
						<th>{{trans('general.sno')}}</th>
						<th scope="col">
							{{trans('user.thead.collector_id')}}
						</th>
						<th scope="col">{{trans('user.thead.created_date')}}<i class="sort sprite"></i></th>
						<th scope="col">
							{{trans('user.thead.collector_name')}}
					</th>
					<th scope="col">
							{{trans('user.thead.mobile_number')}}
					</th>
					<th scope="col" >{{trans('user.thead.email')}}</th>
					<th scope="col">{{trans('general.status')}}</th>
					<th scope="col">{{trans('general.action')}}</th>
				</tr>
			</thead>
			<tbody>
				<tr class="search-table">
					<td></td>
					<td>
						<div class="tooltip1">
							<input type="text" class="form-control" data-ng-model="filters.collector_id">
							<span class="tooltiptext">{{trans('user.filter.collector_id')}}</span>
						</div>
					</td>
					<td>
						<form action="{{ URL::to('partwisecategorisation') }}" method="post">
							{{ csrf_field() }}
							<div class="date-picker-filter from_to">
								<div class="input-group">
									<input onkeypress="return false;" type="text"  class="form-control" data-date-range placeholder="dd-mm-yyyy" name="date_range" data-ng-model="filters.dateRange"><span class="input-group-addon"><i
								class="calender sprite"></i></span>
							</div>
						</div>
					</form>
				</td>
					<td>
						<div class="tooltip1">
							<input type="text" class="form-control" data-ng-model="filters.name">
							<span class="tooltiptext">{{trans('user.filter.collector_name')}}</span>
						</div>
					</td>
					<td>
						<div class="tooltip1">
							<input type="text" class="form-control" data-ng-model="filters.mobile_number">
							<span class="tooltiptext">{{trans('user.filter.mobile_number')}}</span>
						</div>
					</td>
					<td>
						<div class="tooltip1">
							<input type="text" class="form-control" data-ng-model="filters.email">
							<span class="tooltiptext">{{trans('user.filter.email')}}</span>
						</div>
					</td>
				<td>
					<div class="tooltip1">
						<select class="form-control select" ng-init="filters.status='All'" data-ng-change="getRecords(true)" data-ng-model="filters.status">
							<option data-ng-value='All'>{{trans('general.all')}}</option>
							<option data-ng-value='1'>{{trans('general.active')}}</option>
							<option data-ng-value='0'>{{trans('general.inactive')}}</option>
						</select>
						<span class="tooltiptext">{{trans('general.filter_by_status')}}</span>
					</div>
				</td>
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
				<td colspan="8" class="no-data">{{trans('messages.empty_record')}}</td>
			</tr>
			<tr data-ng-if="showRecords" data-on-finish-rendered data-on-finish-rendered-records data-ng-repeat="record in records track by $index">
				
				<td>@{{$index+1}}</td>
				<td  class="whitespace-nowrap" >@{{record.collector_id}}</td>
				<td  class="whitespace-nowrap">@{{record.created_at}}</td>
				<td  class="whitespace-nowrap" >@{{record.name}}</td>
				<td  class="whitespace-nowrap">@{{record.mobile_number}}</td>
			<td  class="whitespace-nowrap" >@{{record.email}}</td>
			<td data-ng-if="record.is_active== 1">
				<label class="active">{{trans('general.active')}}</label>
			</td>
			<td data-ng-if="record.is_active== 0">
				<label class="inactive">{{trans('general.inactive')}}</label>
			</td>
			<td class="">
				<div class="tooltip1">
					<a data-ng-href="{{url('collector/edit').'/'}}@{{record.id}}"> <i class="icon-edit sprite"></i>
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
@include('layouts.pagination',['module_name'=>'Collector'])
</div>
</div>
</div>