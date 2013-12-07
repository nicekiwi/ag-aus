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

      <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/foundation/5.0.2/css/foundation.min.css">
      <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css">
      <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.3/css/base/minified/jquery.ui.slider.min.css">

      <!-- Add fancyBox -->
      <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" />
      <link rel="stylesheet" href="/css/main.css">

      <script src="//cdnjs.cloudflare.com/ajax/libs/foundation/5.0.2/js/modernizr.min.js"></script>
  </head>
  <body>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->
    <header style="background-color: #000; padding:10px 0;">
      <div class="row">
        <nav class="top-bar" data-topbar="">
          <!-- Title -->
          <ul class="title-area">
            <li class="name"><h1><a href="/"><img src="/img/ag-logo.png"></a></h1></li>

            <!-- Mobile Menu Toggle -->
            <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
          </ul>

          <!-- Top Bar Section -->
          <section class="top-bar-section">
            <!-- Top Bar Left Nav Elements -->
            <ul class="left">
              <!-- Dropdown -->
              <li><a href="/news">News</a>
              <li><a href="/games">Games</a></li>
              <li><a href="/maps">Maps</a></li>
            </ul>

            <!-- Top Bar Right Nav Elements -->
            <ul class="right">
              <li><a href="/donate">Donations</a></li>
              <li class="divider"></li>
              <li><a href="/forums">Forums</a></li>

              <!-- If Authenticated -->
              @if(Auth::check())
              <li class="has-dropdown not-click">

                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                     <img src="{{ Gravatar::src(Auth::user()->email, 24) }}" class=""> {{ Auth::user()->username }} <b class="caret"></b>
                </a>
                <ul class="dropdown"><li class="title back js-generated"><h5><a href="#">Back</a></h5></li>
                  <li><a href="/user/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                </ul>
              </li>
              @endif
            </ul>
          </section>
        </nav>
      </div>
    </header>

    <section class="row" style="background:#fff;">
      <div class="small-12 columns">

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
      </div>

      <div class="small-12 columns">
        @yield('content')
      </div>

      <footer class="small-12 columns">
        <p>&copy; Powered by Kiwidev 2013</p>
      </footer>

      <div class="small-12 medium-6 columns">
        @include('partials.donation-widget')
      </div>
      <div class="small-12 medium-6 columns">
        @include('partials.server-list')
      </div>
      <div class="small-12 medium-6 columns">
        @include('partials.event-list')
      </div>
    </section>

    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/foundation/5.0.2/js/jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.pack.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/foundation/5.0.2/js/foundation.min.js"></script>
    @yield('footer')
    <script src="/js/main.js"></script>
  </body>
</html>
