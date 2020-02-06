<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('/home') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>T</b>REE</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Rento</b>TREE</span>
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

          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning head_noti"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header ">You have <span class="head_noti"></span> notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu" id="all_notifications">
                   
                </ul>
              </li>
              <li class="footer"><a href="{{url('notification')}}">View all</a></li>
            </ul>
          </li>

          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-comments-o"></i><span class="label label-warning" id="chat_count"></span></a>
          </li>
          
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
                <img src="{{url('storage/app')}}/{{session('profile_image')}}" class="user-image" alt="User Image">

              <!-- <img src="{{url('storage/app')}}/{{session('profile_image')}}" class="user-image" alt="User Image"> -->
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs">{{ session('first_name') }} {{ session('last_name') }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
              
                <img src="{{url('storage/app')}}/{{session('profile_image')}}" class="img-circle" alt="User Image">
                
                <p>
                  {{ session('first_name') }}  {{ session('last_name') }} - 
                  <?php if(Session::get('role_id') == 1){ echo "ADMIN"; }else{ echo "SHOPKEEPER"; } ?>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ route('website.profile') }}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>
    </nav>
  </header>