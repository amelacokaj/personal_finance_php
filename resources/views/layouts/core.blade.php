<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Inventari') }}</title>
    
    <link href="/css/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="/css/bootstrap.min.css" rel="stylesheet"type="text/css">
    <link href="/css/bootstrap-grid.min.css" rel="stylesheet"type="text/css">
    <link href="/css/bootstrap-reboot.min.css" rel="stylesheet"type="text/css">

    <link href="/css/main.css" rel="stylesheet" type="text/css">

</head>
<body id="app">
	
    @yield('content')

	<!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
</body>
</html>
