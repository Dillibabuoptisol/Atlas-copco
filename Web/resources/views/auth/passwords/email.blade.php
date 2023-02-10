@extends('layouts.login')

<!-- Main Content -->
@section('content')
<div class="login-template forgot-password">
        <div class="left-side">
            <h1 class="logo">
                <img src="{{asset('assets/images/Atlaslogo.png')}}">
            </h1>
            
            <a href="{{ url('admin/auth/login') }}" class="login-page-link"><span class="icon-left-arrow"></span>FORGOT PASSWORD</a>
            
            <div class="info">
                *  Enter your email or User name. We’ll email instructions on how to reset your password.
            </div>
            <form id="form" role="form" method="POST" action="{{ url('/password/email') }}">
            {{ csrf_field() }}
            <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="row">
                    <div class="col-md-12">
                         <div class="form-group has-feedback">
                            <input type="text" id="email" name="email" class="form-control" placeholder="Email / Username">
                            <span class="icon-user form-control-feedback"><span class="path1"></span><span class="path2"></span></span>
                        </div>
                    </div>    
                </div>
                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                </div>
                
                <div class="text-center">
                    <button class="button">Submit</button>   
                </div>
            </form>
            
            <div class="login-footer">
                <div class="branding-logo">
                    <div class="logos">
                        <span class="bharatbenz sprite"></span>
                    </div>
                    <div class="logos">
                        <span class="mercedes sprite"></span>
                    </div>
                    <div class="logos">
                        <span class="fuso sprite"></span>
                    </div>
                </div>
                
                <p>
                    Atlas Copco Ltd.
                    <span>All Rights reserved</span>
                </p>
            </div>
            
        </div>
        <div class="banner"></div>
    </div>
@endsection
