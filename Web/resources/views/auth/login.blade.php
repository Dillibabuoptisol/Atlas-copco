@extends('layouts.login')

@section('content')
<div class="login-template">
        <div class="left-side">
            <h1 class="logo">
                <img src="{{asset('assets/images/Atlaslogo.png')}}">
            </h1>
            
            
            
            <form id="form" role="form" method="POST" action="{{ url('/login') }}">
                <h3>Login</h3>
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}" >
                <div class="row">
                    <div class="col-md-12">
                         <div class="form-group has-feedback">
                            <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                            <span class="icon-user form-control-feedback"><span class="path1"></span><span class="path2"></span></span>
                            @if ($errors->has('email'))
                           <p class="help-block error">{{ $errors->first('email') }}</p>
                         @endif
                        </div>
                    </div>    
                </div>
                </div>
                 
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-feedback">
                            <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                            <span class="icon-lock form-control-feedback"><span class="path1"></span><span class="path2"></span></span>
                                 @if ($errors->has('password'))
                            <span class="help-block error">{{ $errors->first('password') }}</span>
                        @endif
                        </div>
                    </div>    
                </div>
                </div>

                <div class="row">
                     <div class="col-md-6 pull-right" >
                        <label for="remeber-me" class="remeber-me">
                            <a href="{{url('/forgotpassword')}}">Forgot Password</a>
                        </label>

                    </div>  
                </div>
                
                <div class="text-center">
                    <button class="button">{{trans('general.login.sign_in')}}</button>   
                </div>
            </form>
            
            <div class="login-footer">
                <p>
                    {{trans('general.login.footer_quote')}}                    {{trans('general.login.all_rights')}}
                </p>
            </div>
            
        </div>
        
    </div>
@endsection
