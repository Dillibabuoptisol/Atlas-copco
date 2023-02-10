            <div class="headerbar">

				<a class="menutoggle"><i class="icon-menu-toggle"></i></a>

				<h1 class="inner-logo">
                    <a>
                        <img src="{{asset('assets/images/Atlaslogo.png')}}">
                    </a>
                </h1>

				<div class="header-right hidden-xs">
					<ul class="headermenu">
							<li>
							<div class="btn-group">
								<div class="dropdown-toggle user-dropdown padL-zero" data-toggle="dropdown">
                                    <div class="info padL-zero">
                                        <p class="name">{{Auth::user()->name}}
                                        <span class="icon-down-arrow"></span>
                                        </p>
                                    </div>
								</div>
								<ul class="dropdown-menu dropdown-menu-usermenu pull-right">
									<li><a href="{{url('changepassword/index')}}"><i class="glyphicon glyphicon-cog"></i> {{trans('sidebar.adminsidebar.changePassword')}}</a></li>
									<li>
                     					<form method="post" action="{{url('logout')}}" >
                     						{{ csrf_field() }}
                     						<button><i class="glyphicon glyphicon-log-out"></i>{{trans('sidebar.adminsidebar.logOut')}}</button>
                     					</form>
                     				</li>
								</ul>
							</div>
						</li>
					</ul>
				</div>
			</div>