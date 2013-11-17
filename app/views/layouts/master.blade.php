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

        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <style>
            body {
                /*padding-top: 50px;*/
                padding-bottom: 20px;
            }

            .flash{
                padding: 1em;
            }
        </style>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css">
        <link rel="stylesheet" href="/css/main.css">

        <!-- Add fancyBox -->
        <link rel="stylesheet" href="/css/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />

        <script src="/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
          <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
              <img src="/img/ag-logo.png"></a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
              <li class="{{ (Request::is('news*') ? 'active' : '') }}"><a href="/news">News</a></li>
              <li class="{{ (Request::is('games*') ? 'active' : '') }}"><a href="/servers">Games</a></li>
              <li class="{{ (Request::is('maps*') ? 'active' : '') }}"><a href="/maps">Maps</a></li>
              
              <li><a href="/forums">Forums</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
              <li class="{{ (Request::is('donate*') ? 'active' : '') }}"><a href="/donate">Donate</a></li>
              @if(Auth::check())
              <li class="dropdown">
                <a href="#" class="user-admin-menu dropdown-toggle" data-toggle="dropdown">
                     <img src="{{ Gravatar::src(Auth::user()->email, 24) }}" class=""> {{ Auth::user()->username }} <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                  <li><a href="/admin/profile"><span class="glyphicon glyphicon-tasks"></span> Profile</a></li>
                  <li><a href="/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                </ul>
              </li>
              @endif
            </ul>
          </div><!-- /.navbar-collapse -->
          </div>
        </nav>

        <div class="container main-content">

          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-8 clearfix">

              @if(Session::get('flash_message'))
                  <div class="flash">
                      {{ Session::get('flash_message') }}
                  </div>
              @endif

              @if(Session::get('message'))
                  <div class="flash">
                      {{ Session::get('message') }}
                  </div>
              @endif

              <p>&nbsp;</p>

              @yield('content')

              <hr>

              <footer>
                <p>&copy; Powered by Kiwidev 2013</p>
              </footer>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-4">
              @include('partials.donation-widget')
              @include('partials.event-list')
              @include('partials.server-list')
            </div>
          </div>
        </div> <!-- /container -->

        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script type="text/javascript" src="/js/vendor/jquery.fancybox.pack.js?v=2.1.5"></script>
        <script type="text/javascript" src="/js/vendor/jquery.formance.min.js"></script>
        <script type="text/javascript" src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>

        @yield('footer')
        <script src="/js/main.js"></script>
    </body>
</html>
