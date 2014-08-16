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
      <link rel="stylesheet" href="/css/app-admin.css">

  </head>
  <body>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->



      <!-- Static navbar -->
      <div class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/admin">AG Admin</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              @if(Auth::user()->can("manage_servers"))
              <li><a href="/admin/servers">Servers</a></li>
              @endif
              @if(Auth::user()->can("manage_maps"))
              <li><a href="/admin/maps">Maps</a></li>
              @endif
              @if(Auth::user()->can("manage_posts"))
              <li><a href="/admin/posts">Posts</a></li>
              @endif
              @if(Auth::user()->can("run_jukebox"))
              <li><a href="/admin/jukebox">Jukebox</a></li>
              @endif
              @if(Auth::user()->can("manage_bans"))
              <li><a href="/admin/bans">Bans</a></li>
              @endif
              @if(Auth::user()->can("manage_donations"))
              <li><a href="/admin/donations">Donations</a></li>
              @endif
              @if(Auth::user()->can("manage_users"))
              <li><a href="/admin/users">Users</a></li>
              @endif
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <!-- If Authenticated -->
              @if(Auth::check())
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{ Gravatar::src(Auth::user()->email, 20) }}" class=""> {{ Auth::user()->username }} <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="/logout">Logout</a></li>
                </ul>
              </li>
              @endif
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
          <p>&copy; Powered by Kiwidev 2013<span style="float:right;"><a href="/">Public</a></span></p>
        </footer>
      </section>
      
    </div>
    <script src="/js/app-admin.js"></script>
    @yield('footer')
  </body>
</html>