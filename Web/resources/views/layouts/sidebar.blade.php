        <div class="leftpanel">

			<div class="side-bar-scroll">
                <div class="leftpanelinner">
                    <!-- This is only visible to small devices -->
                    <div class="visible-xs hidden-sm hidden-md hidden-lg account-sidebar">
                        <div class="media userlogged">
                            <div class="media-body">
                                <h4>{{Auth::user()->name}}</h4>
                            </div>
                        </div>

                        <h5 class="sidebartitle actitle">Account</h5>
                        <ul class="nav nav-pills nav-stacked nav-bracket mb30">
                            <li><a href="{{url('myprofile/edit',[Auth::user()->id])}}"><i class="fa fa-user"></i> <span>{{trans('contentheader.adminheader.my-profile')}}</span></a></li>
                            <li><a href="{{url('changepassword/index')}}"><i class="fa fa-cog"></i> <span>{{trans('sidebar.adminsidebar.changePassword')}}</span></a></li>
                            <li><a href="{{url('logout')}}"><i class="fa fa-sign-out"></i>
                                    <span>{{trans('sidebar.adminsidebar.logOut')}}</span></a></li>
                        </ul>
                    </div>

                    <ul class="nav nav-pills nav-stacked nav-bracket">
                        <li class="{{$isRouteActive('receiptvoucher')}}">
                            <a href="{{url('receiptvoucher')}}">
                                <i class="icon-rv sprite"></i> 
                                <span>Receipt Vouchers</span>
                            </a>
                        </li>

                        <li class="{{$isRouteActive('collector')}}">
                            <a href="{{url('collector')}}">
                                <i class="icon-manage-collector sprite"></i> 
                                <span>Manage Collector</span>
                            </a>
                        </li>

                        <li class="{{$isRouteActive('admin')}}">
                            <a href="{{url('admin')}}">
                                <i class="icon-user-management sprite"></i> 
                                <span>Manage Admin</span>
                            </a>
                        </li> 
                        <li class="{{$isRouteActive('email')}}">
                            <a href="{{url('email')}}">
                                <i class="icon-email-template sprite"></i> 
                                <span>Email Templates</span>
                            </a>
                        </li>                   
                        <li class="{{$isRouteActive('settings')}}">
                            <a href="{{url('settings')}}">
                                <i class="icon-settings sprite"></i> 
                                <span>Settings</span>
                            </a>
                        </li> 
                    </ul>
                </div>
            </div>
	</div>
