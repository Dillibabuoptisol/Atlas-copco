    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
	    <meta name="admin-api-url" data-service="admin" content="{{ url('/api') }}">
	    <meta name="bulkupload-api-url" data-service="bulkupload" content="{{ url('/api') }}">
	    <meta name="myprofile-api-url" data-service="myprofile" content="{{ url('/api') }}">
	    <meta name="base-api-url" content="{{ url('/api') }}">
	    <meta name="base-template-url" content="{{url('/')}}"> 
        <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}" type="image/png">

        <title>Atlas Copco</title>
        
        <link href="{{asset('assets/css/icomoon.css')}}" rel="stylesheet">
        <link href="{{asset('assets/css/jquery.mCustomScrollbar.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/css/jquery-ui-1.10.3.css')}}" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="{{asset('assets/css/dropzone.css')}}" rel="stylesheet">
        <link href="{{asset('assets/css/style.default.css')}}" rel="stylesheet">
        <link href="{{asset('assets/css/responsive.css')}}" rel="stylesheet">
        <link href="{{asset('assets/css/mbri_style.css')}}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/daterangepicker.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/bootstrap-wysihtml5.css')}}"> 
    </head>