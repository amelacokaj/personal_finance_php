<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Money Manager') }}</title>
    
    <link href="/css/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="/css/bootstrap.min.css" rel="stylesheet"type="text/css">
    <link href="/css/bootstrap-grid.min.css" rel="stylesheet"type="text/css">
    <link href="/css/bootstrap-reboot.min.css" rel="stylesheet"type="text/css">

    <link href="/css/gijgo-core.min.css" rel="stylesheet" type="text/css">
    <link href="/css/gijgo-datepicker.min.css" rel="stylesheet" type="text/css">

    <link href="/css/select2/select2.min.css" rel="stylesheet" type="text/css">
    <link href="/css/select2/select2-bootstrap4.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="/css/datatables.min.css"/>

    <link href="/css/main.css" rel="stylesheet" type="text/css">

</head>
<body id="app">
	<header>
		<!-- Fixed navbar -->
		<nav class="navbar navbar-dark fixed-top bg-dark navbar-expand-md flex-md-nowrap p-0 shadow">
			<a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{ url('/home') }}">
				{{ config('app.name', 'Money Manager') }}
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<ul class="navbar-nav mr-auto main-menu-buttons">
            <li class="nav-item">
              <a class="nav-link" href="/supply/create">
                <i class="fa fa-ship" aria-hidden="true" style="margin-left: 15px; margin-right: 7px;"></i>
                FURNIZIM/IMPORT I RI <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/distribution/create">
                <i class="fa fa-truck fa-flip-horizontal" aria-hidden="true" style="margin-left: 15px; margin-right: 7px;"></i>
                FATURE DYQANI <span class="sr-only">(current)</span>
              </a>
            </li>
				</ul>
				<ul class="navbar-nav mt-2 mt-md-0">
            <li class="nav-item">
              <div class="dropdown">
                <button class="btn btn-link nav-link dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Settings
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="/users">Perdoruesit</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="/brands">Markat</a>
                  <a class="dropdown-item" href="/product-types">Tipe Produktesh</a>
                  <a class="dropdown-item" href="/categories">Kategorite</a>
                  <a class="dropdown-item" href="/colors">Ngjyrat</a>
                  <a class="dropdown-item" href="/location-types">Lloje Pikash</a>
                </div>
              </div>
            </li>
					<li class="nav-item">
						<a class="nav-link" href="/users/1/edit">
							<i class="fa fa-user-circle-o" aria-hidden="true"></i>
							Username
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/logout">
							<i class="fa fa-sign-out" aria-hidden="true"></i>
							Dil
						</a>
					</li>
				</ul>
			</div>
		</nav>
	</header>

  <div class="container-fluid">
    @yield('content')
  </div>

	<!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/gijgo.min.js"></script>
    
    <script src="/js/select2/select2.full.min.js"></script>
    <script src="/js/jquery.csv.min.js"></script>
    <script src="/js/bootbox.min.js"></script>
    
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="/js/datatables.min.js"></script>

    <script src="/js/helper.js"></script>

    <script>
        //GLOBAL CONSTANT
        Utils.CSRF_TOKEN = '<?php echo csrf_token(); ?>';
        
        $.fn.select2.defaults.set( "theme", "bootstrap4" );
        $(document).ready(function(){
            //open clicked image in a new tab
            $('img.thumb').click(function() {
                var path = $(this).attr("src");
                window.open(path, '_blank');
            });
        });

        function isCSVFileReaderAPIAvailable() {
          // Check for the various File API support.
          if (window.File && window.FileReader && window.FileList && window.Blob) {
            // Great success! All the File APIs are supported.
            return true;
          } else {
            // source: File API availability - http://caniuse.com/#feat=fileapi
            // source: <output> availability - http://html5doctor.com/the-output-element/
            document.writeln('The HTML5 APIs used in this form are only available in the following browsers:<br />');
            // 6.0 File API & 13.0 <output>
            document.writeln(' - Google Chrome: 13.0 or later<br />');
            // 3.6 File API & 6.0 <output>
            document.writeln(' - Mozilla Firefox: 6.0 or later<br />');
            // 10.0 File API & 10.0 <output>
            document.writeln(' - Internet Explorer: Not supported (partial support expected in 10.0)<br />');
            // ? File API & 5.1 <output>
            document.writeln(' - Safari: Not supported<br />');
            // ? File API & 9.2 <output>
            document.writeln(' - Opera: Not supported');
            return false;
          }
        }
    </script>

    @yield('scripts')
</body>
</html>
