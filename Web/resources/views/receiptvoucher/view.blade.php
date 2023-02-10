@extends('layouts.common')
@section('section')
<section class="view-page rv-alters">
    @include('layouts.sidebar')
    <div class="mainpanel">
        @include('layouts.containerhead')
        @include('layouts.notifications')

        <div class="pageheader clearfix">
            <div class="col-md-8 no-icon no_padding">
                <h2>{{trans('receiptvouchers.details')}}</h2>
            </div>
			 <div class="col-md-4 text-right">
                <a href="{{url('receiptvoucher')}}">
                <button type="button" class="back_button">{{trans('receiptvouchers.back')}}</button></a>
            </div>
        </div>        <div class="content"  data-ng-controller="RVUserController as rVCtrl" data-ng-init = "rVCtrl.fetchReceiptVoucherSingleInfo({{$id}})">
            <div class="one-set">
                <h3 class="heading-part">
                    <span>{{trans('receiptvouchers.info')}}</span>
                </h3>

                <div class="rv-info section-divide">
                    <div class="rv-number left-side">
                        <div class="text-image">
                            <div class="text">    
                                <h5>{{trans('receiptvouchers.rvnumber')}}</h5>
                                <p><a href="javascript:void(0)">@{{rVCtrl.receiptVoucher.rv_form_number}}</a></p>
                            </div>
                        </div>
                    </div>

                    <div class="right-side-one">
                        <h5>{{trans('receiptvouchers.rvdate')}}</h5>
                        <p>@{{rVCtrl.receiptVoucher.rv_created_date | date:'longDate'}}</p>
                    </div>
                    <div class="right-side-one">
                        <h5>{{trans('receiptvouchers.rvimage')}}</h5>
                        <div invoice class="image" id="rvgallery">
                                <div class="item" data-src="@{{rVCtrl.receiptVoucher.rv_form_image}}" data-sub-html="<h4>@{{rVCtrl.receiptVoucher.rv_form_number}}</h4>">
                                   <a href="">
                                        <img src="@{{rVCtrl.receiptVoucher.rv_form_image}}" class="img-responsive rvimg">
                                    </a>
                                </div>
                                
                            </div>
                    </div>
                </div>
            </div>

            <div class="one-set">
                <h3 class="heading-part">
                    <span>{{trans('receiptvouchers.customerinfo')}}</span>
                </h3>

                <div class="rv-info section-divide">
                    <div class="rv-number left-side">
                        <div class="text-icon">                            
                            <h5>
                                <span>{{trans('receiptvouchers.customer_name')}}</span>
                            </h5>
                            <p>@{{rVCtrl.receiptVoucher.customer_name}}</p>                            
                        </div>
                    </div>

                    <div class="center-side">
                        <h5>{{trans('receiptvouchers.customer_code')}}</h5>
                        <p>@{{rVCtrl.receiptVoucher.customer_code}}</p>
                    </div>

                    <div class="right-side">
                        <h5>{{trans('receiptvouchers.customer_number')}}</h5>
                        <p>@{{rVCtrl.receiptVoucher.customer_contact_number}} </p>
                    </div>
                </div>
            </div>

            <div class="one-set">
                <h3 class="heading-part">
                    <span>{{trans('receiptvouchers.payment_info')}}</span>
                </h3>

                <div class="rv-info section-divide">
                    <div class="rv-number left-side">
                        <h5>{{trans('receiptvouchers.currency_type')}}</h5>
                        <p>@{{rVCtrl.receiptVoucher.currencies.currency_name}}</p>
                    </div>

                    <div class="center-side">
                        <h5>{{trans('receiptvouchers.amount')}}</h5>
                        <p>@{{rVCtrl.receiptVoucher.amount}}</p>
                    </div>

                    <div class="right-side">
                        <h5>{{trans('receiptvouchers.payment_type')}}</h5>
                        <p>@{{rVCtrl.receiptVoucher.payment_type.payment_name}}</p>
                    </div>

                    <div class="rv-number left-side">
                        <h5>{{trans('receiptvouchers.cheque_number')}}</h5>
                        <p>@{{rVCtrl.receiptVoucher.cheque_numbers}}</p>
                    </div>

                    <div class="center-side">
                        <h5>{{trans('receiptvouchers.bank_details')}}</h5>
                        <p>@{{rVCtrl.receiptVoucher.bank_details}}</p>
                    </div>
                    <div class="right-side">
                        <h5>{{trans('receiptvouchers.payment_category')}}</h5>
                        <p>@{{rVCtrl.receiptVoucher.payment_category.category_name}}</p>
                    </div>

                    <div class="rv-number left-side">
                        <h5>{{trans('receiptvouchers.branch_name')}}</h5>
                        <p>@{{rVCtrl.receiptVoucher.branches.branch_name}}</p>
                    </div>
                    <div class="right-side-one">
                        <h5>{{trans('receiptvouchers.invoice_division')}}</h5>
                        <p>@{{rVCtrl.receiptVoucher.rv_division}}</p>
                    </div>
                   
                </div>
            </div>

            <div class="one-set">
                <h3 class="heading-part">
                    <span>{{trans('receiptvouchers.collector_info')}}</span>
                </h3>

                <div class="rv-info section-divide">
                    <div class="rv-number left-side">
                        <h5>{{trans('receiptvouchers.collector_name')}}</h5>
                        <p>@{{rVCtrl.receiptVoucher.collector_name}}</p>
                    </div>

                    <div class="center-side">
                        <h5>{{trans('receiptvouchers.collector_id')}}</h5>
                        <p>@{{rVCtrl.receiptVoucher.collector_id}}</p>
                    </div>

                    <div class="right-side">
                        <h5>{{trans('receiptvouchers.collector_mobile_number')}}</h5>
                        <p>@{{rVCtrl.receiptVoucher.collector_mobile_number}}</p>
                    </div>

                    <div class="rv-number left-side">
                        <h5>{{trans('receiptvouchers.collector_email')}}</h5>
                        <p>@{{rVCtrl.receiptVoucher.collector_email}}</p>
                    </div>
                    <div class="center-side right-full">
                        <h5>{{trans('receiptvouchers.comments')}}</h5>
                        <p>@{{rVCtrl.receiptVoucher.comments}}</p>
                    </div>
                </div>
            </div>

            <div class="one-set">
                <h3 class="heading-part">
                    <span>{{trans('receiptvouchers.additional_Info')}}</span>
                </h3>
                <div class="rv-info section-divide">
                    <div class="col-md-4">
                          <h5>{{trans('receiptvouchers.transaction_number')}}</h5>
                          <input type="text" id = 'field1' class="form-control" name="transaction_number" data-ng-model="rVCtrl.receiptVoucher.transaction_number">

                    </div>
                    <div class="col-md-4">
                          <h5>Date</h5>
                                <div class="date-picker-filter from_to">
                                        <div class="input-group">
                                            <input onkeypress="return false;" type="text" class="form-control" data-transaction-date placeholder="dd-mm-yyyy " name="transaction_date" data-ng-model="rVCtrl.receiptVoucher.transaction_date"><span class="input-group-addon"><i class="calender sprite"></i></span>
                                        </div>
                                    </div>
                    </div>
                    <div class="col-md-4 save-btn-blk">
                    <h5></h5>
                 <button type="button" data-toggle="modal" ng-click = "rVCtrl.saveData()" class="btn btn-primary">Save</button>
                 </div>
                  </div>

            </div>




            <div class="one-set" data-ng-show="rVCtrl.invoiceImages">
                <h3 class="heading-part">
                    <span>{{trans('receiptvouchers.invoice')}} (@{{rVCtrl.invoiceCount}})</span>
                </h3>
				 <div class="rv-info slider-section" >
                    <div class="slider demo-gallery">
                        <div id="lightgallery" class="lightgallery">
                            <div  invoice ng-repeat="x in rVCtrl.invoiceDetails" class="item" data-src="@{{x.invoice_image}}" data-sub-html="<h4>@{{x.rv_form_number}}-@{{x.invoice_number}}-@{{x.invoice_division}}</h4>">
                                <h4>@{{x.rv_form_number}}-@{{x.invoice_number}}-@{{x.invoice_division}}</h4>
                               <a href>
                                    <img src="@{{x.invoice_image}}" class="img-responsive">
                                 </a>
                             </div>
                        </div>

                        <button data-ng-if="rVCtrl.loadMore" data-ng-click="rVCtrl.showAllImages(rVCtrl.receiptVoucher.rv_form_number)" class="load-more">{{trans('receiptvouchers.load_more')}}</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
@section('scripts')
<link href="{{asset('assets/css/lightgallery.css')}}" rel="stylesheet">
<script src="{{asset('assets/js/modules/base/requestFactory.js')}}"></script>
<script src="{{asset('assets/js/modules/base/Validate.js')}}"></script>
<script src="{{asset('assets/js/modules/base/validatorDirective.js')}}"></script>
<script src="{{asset('assets/js/modules/base/notificationDirective.js')}}"></script>
<script src="{{asset('assets/js/modules/base/Uploader.js')}}"></script>
<script src="{{asset('assets/js/modules/receiptvoucher/app.js')}}"></script>
<script src="{{asset('assets/js/lightgallery.js')}}"></script>
<script src="{{asset('assets/js/lg-zoom.js')}}"></script>
<script src="{{asset('assets/js/lg-fullscreen.js')}}"></script>
<script src="{{asset('assets/js/jquery.mousewheel.min.js')}}"></script>
<script type="text/javascript">
      $(document).ready(function() {
        setTimeout(function(){  $("#rvgallery").lightGallery({zoom:'true',fullScreen:'true'});  }, 1000);
    });
      function disablefield1() {
    document.getElementById("field1").disabled = false;
}
function disablefield2() {
    document.getElementById("field2").disabled = false;
}
</script>
@endsection