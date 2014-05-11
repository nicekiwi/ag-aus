<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
  <head>
      <meta charset="utf-8">
      <meta name="stripe-key" content="{{ Config::get('stripe.publishable_key') }}">
      @yield('meta')
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <title></title>
      <meta name="description" content="">
      <meta name="viewport" content="width=device-width">

      <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css">
      <link rel="stylesheet" href="/css/app.css">

  </head>
  <body>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

      <!-- Static navbar -->
      <div class="navbar navbar-inverse navbar-static-top" role="navigation">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Alternative Gaming</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <!-- <li><a href="/events">Events</a></li> -->
              <li><a href="/maps">Maps</a></li>
              <!-- <li><a href="/tools">Tools</a></li> -->
              <li><a href="/bans">Bans</a></li>
              <li><a href="/donate">Donate</a></li>
              <li><a href="http://ag-aus.gameme.com" target="_blank">Stats</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a target="_blank" href="http://community.ag-aus.org">Forums</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>

  <div class="container">

      <section class="row">
        <div class="col-sm-12">
          <!-- Display Alert messages -->
          @include('partials.error-messages')
        </div>

        <div class="col-sm-12">
          @yield('content')
        </div>

        <footer class="col-sm-12">
          <p>&copy; Powered by Kiwidev 2013
          @if(Auth::check())
          <span style="float:right;"><a href="/admin">Admin</a></span>
          @endif
          </p>
        </footer>
      </section>
      
    </div>
    <script src="/js/app.js"></script>
    @yield('footer')
  </body>
</html>