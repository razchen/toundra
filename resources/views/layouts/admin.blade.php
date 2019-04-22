<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div id="app">
        <div class="wrapper">

          <!-- Main Header -->
          <header class="main-header">

            <!-- Logo -->
            <a href="/" class="logo">
              <!-- mini logo for sidebar mini 50x50 pixels -->
              <span class="logo-mini"><b>A</b>LT</span>
              <!-- logo for regular state and mobile devices -->
              <span class="logo-lg"><b>Admin</b>LTE</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
              <!-- Sidebar toggle button-->
              <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
              </a>
              <!-- Navbar Right Menu -->
              <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                  
                  @auth
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                      <!-- Menu Toggle Button -->
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <!-- <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> -->
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span>{{ Auth::user()->name }}</span>
                      </a>
                      <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                          <!-- <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"> -->

                          <p>
                            {{ Auth::user()->name }}
                            <!-- <small>Member since Nov. 2012</small> -->
                          </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                          <!-- <div class="row">
                            <div class="col-xs-4 text-center">
                              <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                              <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                              <a href="#">Friends</a>
                            </div>
                          </div> -->
                          <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                          <!-- <div class="pull-left">
                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                          </div> -->

                          <div class="pull-right">
                            <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> <span>Logout</span></a>
                          </div>
                        </li>
                      </ul>
                    </li>
                  @endauth
                </ul>
              </div>
            </nav>
          </header>
          <!-- Left side column. contains the logo and sidebar -->
          <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
              <!-- Sidebar Menu -->
              <ul class="sidebar-menu" data-widget="tree">
                <li class="header">NAVIGATION</li>
                <!-- Optionally, you can add icons to the links -->
                @guest
                  <li class="active"><a href="/login"><i class="fa fa-sign-in"></i> <span>Login</span></a></li>
                  <li class="active"><a href="/register"><i class="fa fa-plus"></i> <span>Register</span></a></li>
                @else
                  @if (Auth::user()->type == 'admin')
                    <li class="active"><a href="/admin/cameras"><i class="fa fa-camera"></i> <span>Cameras</span></a></li>
                    <li class="active"><a href="/admin/models"><i class="fa fa-cube"></i> <span>Models</span></a></li>
                    <li class="active"><a href="/admin/scenes"><i class="fa fa-binoculars"></i> <span>Scenes</span></a></li>
                    <li class="active"><a href="/protocols"><i class="fa fa-server"></i> <span>Protocols</span></a></li>
                  @else
                    <li class="active"><a href="/cameras"><i class="fa fa-camera"></i> <span>Cameras</span></a></li>
                    <li class="active"><a href="/models"><i class="fa fa-cube"></i> <span>Models</span></a></li>
                    <li class="active"><a href="/scenes"><i class="fa fa-binoculars"></i> <span>Scenes</span></a></li>
                  @endif
                @endguest

                @auth
                  <li class="active">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> <span>Logout</span></a>
                  </li>
                @endauth

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <!-- <li class="treeview">
                  <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#">Link in level 2</a></li>
                    <li><a href="#">Link in level 2</a></li>
                  </ul>
                </li> -->
              </ul>
              <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
          </aside>

          <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
              <h1>
                @yield('header')
                <small>@yield('description')</small>
              </h1>
              <ol class="breadcrumb">
                @yield('breadcrumbs')
              </ol>
            </section>

            <!-- Main content -->
            <section class="content container-fluid">
              @yield('content')
            </section>
            <!-- /.content -->
          </div>
          <!-- /.content-wrapper -->

          <!-- Main Footer -->
          <footer class="main-footer">
            <!-- To the right -->
            <div class="pull-right hidden-xs">
              Anything you want
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; {{ date('Y') }} <a href="/">{{ config('app.name', 'Laravel') }}</a>.</strong> All rights reserved.
          </footer>
        </div>
        <!-- ./wrapper -->
    </div>
</body>
</html>