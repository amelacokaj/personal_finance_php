<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>">

    <title>Money</title>

    <link href="/css/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="/css/bootstrap.min.css" rel="stylesheet"type="text/css">
    <link href="/css/bootstrap-grid.min.css" rel="stylesheet"type="text/css">
    <link href="/css/bootstrap-reboot.min.css" rel="stylesheet"type="text/css">

    <link href="/css/gijgo-core.min.css" rel="stylesheet" type="text/css">
    <link href="/css/gijgo-datepicker.min.css" rel="stylesheet" type="text/css">

    <link href="/css/select2/select2.min.css" rel="stylesheet" type="text/css">
    <link href="/css/select2/select2-bootstrap4.min.css" rel="stylesheet" type="text/css">

    <link href="/css/main.css" rel="stylesheet" type="text/css">

    <!-- JavaScript -->
    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/gijgo.min.js"></script>
    
    <script src="/js/select2/select2.full.min.js"></script>
    <script src="/js/jquery.csv.min.js"></script>
    <script src="/js/bootbox.min.js"></script>
    
    <script src="/js/helper.js"></script>

    <script>
      //GLOBAL CONSTANT
      Utils.CSRF_TOKEN = '<?php echo csrf_token(); ?>';
            
      $(document).ready(function(){
        //open clicked image in a new tab
        $('img.thumb').click(function() {
          var path = $(this).attr("src");
          window.open(path, '_blank');
        });
        
      });
    </script>

  </head>

  <body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
      <a class="navbar-brand" href="/">Home</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="/transactions">Transactions</a>
          </li>
          <li class="nav-item"> 
            <a class="nav-link" href="/transactions/list/income">Income</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/transactions/list/expense">Expense</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/raports">Raports</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/categories">Categories</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/accounts">Accounts</a>
          </li>
        </ul>
        <form class="form-inline mt-2 mt-md-0">
          <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>

    <main role="main" class="container">