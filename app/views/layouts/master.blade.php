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
        <!-- Add fancyBox -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" />
        <link rel="stylesheet" href="/css/main.css">

        <script src="//cdnjs.cloudflare.com/ajax/libs/foundation/5.0.2/js/modernizr.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-8 main-content">

              <nav class="top-bar" data-topbar="">
                <!-- Title -->
                <ul class="title-area">
                  <li class="name"><h1><a href="#"><img src="/img/ag-logo.png"></a></h1></li>

                  <!-- Mobile Menu Toggle -->
                  <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
                </ul>

                <!-- Top Bar Section -->
                
                <section class="top-bar-section">

                    <!-- Top Bar Left Nav Elements -->
                    <ul class="left">
                      <!-- Dropdown -->
                      <li><a href="/news">News</a>
                      <li class="has-dropdown not-click"><a href="/games">Games</a>
                        <ul class="dropdown"><li class="title back js-generated"><h5><a href="#">Back</a></h5></li>
                          <li><a href="/games/team-fortress-2">Team Fortress 2</a></li>
                          <li><a href="/games/minecraft">Minecraft</a></li>
                        </ul>
                      </li>
                      <li><a href="/maps">Maps</a></li>
                    </ul>

                    <!-- Top Bar Right Nav Elements -->
                    <ul class="right">
                      <li><a href="/donate">Donations</a></li>
                      <li class="divider"></li>
                      <li><a href="/forums">Forums</a></li>
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
              <h3>{{ date('F') }} Donations</h3>
              <p></p>
              <div class="progress-percent">$42 of $140 Donated</div>
              <div class="progress">

                <div class="progress-bar" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%;">
                  <span class="sr-only">30% Complete</span>
                </div>
              </div>

              <h3>Events</h3>


              <h3>Our Servers</h3>
              <ul id="master-server-list">
              @foreach($servers as $server)
                <li class="check-server-status" style="background-color: #{{ ($server->offline === 1 ? 'e24648' : '87ef2f') }}" data-id="server-{{ $server->id }}">
                  <img src="/img/server-load-32.gif">
                  <div>
                    {{ $server->name }}<br>
                    {{ $server->ipaddress }} - <span class="players">{{ $server->players }}</span> / <span class="maxPlayers">{{ $server->maxPlayers }}</span> Players 
                  </div>
                  
                </li>
              @endforeach
              </ul>
            </div>
          </div>

        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/foundation/5.0.2/js/jquery.min.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.pack.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/foundation/5.0.2/js/foundation.min.js"></script>
        @yield('footer')
        <script src="/js/main.js"></script>
    </body>
</html>
