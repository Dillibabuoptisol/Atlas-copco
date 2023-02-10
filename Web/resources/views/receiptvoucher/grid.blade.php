<div class="">
	<div class="mainpanel-template">
		<div class="header-filter clearfix">
			<h3>{{trans('receiptvouchers.receiptvouchers')}}</h3>
			<div class="filter">
				<button type="button" data-toggle="modal" data-target="#exportclk"  class="create-new exporthov">{{trans('receiptvouchers.export')}}</button>
			</div>
		</div>
		<!-- Tab panes -->
		<div class="table-responsive normal-table">
			<div id="table_loader" class="table_loader_container ng-hide" data-ng-show="tableLoader">
				<div class="table_loader">
					<div class="loader"></div>
				</div></div>
				<table class="table">
					<thead class="header">
						<tr>
							<th>{{trans('general.sno')}}</th>
							<th scope="col">
								{{trans('general.rv_number')}}
							</th>
							<th scope="col">{{trans('general.created')}}</th>
							<th scope="col">{{trans('general.customer_code')}}</th>
							<th scope="col">{{trans('general.customer_name')}}</th>
							<th scope="col">{{trans('general.collector_id')}}</th>
							<th scope="col">{{trans('general.collector_name')}}</th>
							<th scope="col">{{trans('general.amount')}}</th>
							<th scope="col">{{trans('general.currency')}}</th>
							<th scope="col">{{trans('general.payment_type')}}</th>
							<th scope="col">{{trans('general.edited_by')}}</th>
							<th>Action</th>

						</tr>
					</thead>
					<tbody>
						<tr class="search-table">
							<td></td>
							<td>
								<div class="tooltip1">
									<input type="text" class="form-control" data-ng-model="filters.rv_form_number">
									<span class="tooltiptext">{{trans('user.filter.rv_form_number')}}</span>
								</div>
							</td>
							<td>
								<form action="{{ URL::to('partwisecategorisation') }}" method="post">
									{{ csrf_field() }}
									<div class="date-picker-filter from_to">
										<div class="input-group">
											<input onkeypress="return false;" type="text" class="form-control" data-date-range placeholder="dd-mm-yyyy " name="date_range" data-ng-model="filters.dateRange"><span class="input-group-addon"><i class="calender sprite"></i></span>
										</div>
									</div>
								</form>
							</td>
							<td>
								<div class="tooltip1">
									<input type="text" class="form-control" data-ng-model="filters.customer_code">
									<span class="tooltiptext">{{trans('user.filter.customer_code')}}</span>
								</div>
							</td>
							<td>
								<div class="tooltip1">
									<input type="text" class="form-control" data-ng-model="filters.customer_name">
									<span class="tooltiptext">{{trans('user.filter.customer_name')}}</span>
								</div>
							</td>
							<td>
								<div class="tooltip1">
									<input type="text" class="form-control" data-ng-model="filters.collector_id">
									<span class="tooltiptext">{{trans('user.filter.collector_id')}}</span>
								</div>
							</td>
							<td>
								<div class="tooltip1">
									<input type="text" class="form-control" data-ng-model="filters.collector_name">
									<span class="tooltiptext">{{trans('user.filter.collector_name')}}</span>
								</div>
							</td>
							<td>
								<div class="tooltip1">
									<input type="text" class="form-control" data-ng-model="filters.amount">
									<span class="tooltiptext">{{trans('user.filter.amount')}}</span>
								</div>
							</td>
							<td>
								<div class="tooltip1">
									<select class="form-control select" data-ng-change="getRecords(true);"
										data-ng-model="filters.currency_type"
										data-ng-options='currency.id as currency.currency_name for currency in moreInfo.currency_type'>
										<option value=''>{{trans('general.all')}}</option>
									</select>
									<span class="tooltiptext">{{trans('user.filter.currency')}}</span>
								</div>
							</td>
							<td>
								<div class="tooltip1">
									<select class="form-control select" data-ng-change="getRecords(true);"
										data-ng-model="filters.payment_type"
										data-ng-options='category.id as category.payment_name for category in moreInfo.payment_type'>
										<option value=''>{{trans('general.all')}}</option>
									</select>
									<span class="tooltiptext">{{trans('user.filter.payment_type')}}</span>
								</div>
							</td>
							<td>
								<div class="tooltip1">
									<input type="text" class="form-control" data-ng-model="filters.edit_by">
									<span class="tooltiptext">{{trans('user.filter.edit_by')}}</span>
								</div>
							</td>
							<td class="whitespace-nowrap">
								<button type="button" data-ng-click="doGridSearch()"
								class="btn search warning" data-boot-tooltip="true"
								data-toggle="tooltip"
								data-original-title="{{trans('general.search')}}">
								<i class="fa fa-search"></i>
								</button>
								<button type="button" class="danger product_list_reset_btn btn" name="reset" data-ng-click="gridReset()" value="{{trans('general.reset')}}" data-boot-tooltip="true" data-toggle="tooltip" data-original-title="{{trans('general.reset')}}">
								<i class="fa fa-refresh"></i>
								</button>
							</td>
							<td></td>
						</tr>
						<tr data-ng-if="noRecords">
							<td colspan="12" class="no-data">{{trans('messages.empty_record')}}</td>
						</tr>
						<tr data-ng-if="showRecords" data-on-finish-rendered data-on-finish-rendered-records data-ng-repeat="record in records track by $index">
							<td>@{{$index+1}}</td>
							<td class="whitespace-nowrap">
								<a data-ng-href="{{url('receiptvoucher/view').'/'}}@{{record.id}}">
											@{{record.rv_form_number}}
								</a>
							</td>
							<td class="whitespace-nowrap">@{{record.rv_created_date}}</td>
							<td class="whitespace-nowrap">@{{record.customer_code}}</td>
							<td  class="whitespace-nowrap" >@{{record.customer_name}}</td>
							<td class="whitespace-nowrap">@{{record.collector_id}}</td>
							<td>@{{record.collector_name}}</td>
							<td class="whitespace-nowrap" >@{{record.amount}}</td>
							<td>@{{record.currencies.currency_name}}</td>
							<td>@{{record.payment_type.payment_name}}</td>
							<td class="edit-by">@{{record.edit_by}}</td>
							<td class="action-blk">
							
									<a class="icon-delete" data-toggle="modal" data-target="#deleteReceiptModal" data-ng-click="setDeleteID(record.id)">
										</a>
							</td>
							
							<!-- <td></td> -->
						</tr>
					</tbody>
				</table>
			</div>
			<div class="custom-pagination clearfix">
				@include('layouts.pagination',['module_name'=>'Receiptvoucher'])
			</div>
		</div>
	</div>

	<div id="exportclk" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exportclicklabel">
		<div class="modal-dialog minwidth" role="">
			<div class="modal-content relat">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Export</h4>
				</div>
				<div class="modal-body">
					<h4 class="text-center">
					Export Receipt Voucher data based on created date
					</h4>
				<div class="date-picker-filter from_to">
					<div class="input-group">
					<input onkeypress="return false;" type="text" class="form-control" data-date-range-export placeholder="dd-mm-yyyy  dd-mm-yyyy" name="date_range_export" data-ng-model="xldates.dateRangeValue"><span class="input-group-addon"><i class="calender sprite"></i></span>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>

	    <div class="modal fade" id="deleteReceiptModal"   data-role="dialog">
        <div class="modal-dialog delete-popup">
            <div class="modal-content" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    @if(isset($module_name))
                        <h4 class="modal-title"> Delete Receipt Voucher </h4>
                    @else
                        <h4 class="modal-title"> Delete Receipt Voucher </h4>
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
                    <span data-ng-click="deleteRecord()" class="btn btn-primary pull-right mr10"
                        data-dismiss="modal">{{trans(MESSAGE_CONFIRM)}}</span>
                 </div>
            </div>
        </div>
    </div>