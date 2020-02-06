<!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
         <!--  <img src="{{url('storage/app')}}/{{session('profile_image')}}" class="img-circle" alt="User Image"> -->
         <?php if(!empty(Session::get('profile_image'))){ ?>
           <img src="{{url('storage/app')}}/{{session('profile_image')}}" class="img-circle" alt="User Image">
         <?php  }else{ ?>
           <img src="{{url('storage/app/pro_image')}}/default.jpeg" class="img-circle" alt="User Image">
         <?php  } ?>
        </div>
        <div class="pull-left info">
          <p>{{ session('first_name') }} {{ session('last_name') }}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form (Optional) -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
        </div>
      </form> -->
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <!-- <li class="header">HEADER</li> -->

        <!-- Optionally, you can add icons to the links -->
        <li <?php if(Request::url() === url('/home')){ echo 'class="active"'; } ?> ><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>

        <?php if(Session::get('role_id') == 1){ ?>

        <li><a href="{{ url('/complain') }}"><i class="fa fa-balance-scale"></i> <span>Complaints Management</span></a></li>
        
        <li class="treeview">
          <a href="#"><i class="fa fa-user"></i> <span>User</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('/shopkeeper') }}"><span> Shopkeeper Management</span></a></li>
            <li><a href="{{ url('/delivery') }}"><span> Delivery boy Management</span></a></li>
            <li><a href="{{ url('/customer') }}"><span> Customer Management</span></a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#"><i class="fa fa-money"></i> <span>Coupon</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('/discount') }}"><span> Discount Management</span></a></li>
            <li><a href="{{ url('/referral') }}"><span> Referral Management</span></a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#"><i class="fa fa-list"></i> <span>Category</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('/category') }}"><span> Category Management</span></a></li>
            <li><a href="{{ url('/subcategory') }}"><span> Subcategory Management</span></a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#"><i class="fa fa-gears"></i> <span>Master Setting</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('/slider') }}"><span> Slider Management</span></a></li>
            <li><a href="{{ url('/warehouse') }}"><span> Warehouse Management</span></a></li>
          </ul>
        </li>

        <?php }  ?>

        <li class="treeview">
          <a href="#"><i class="fa fa-list"></i> <span>Product</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('/product') }}"><span> Product Management</span></a></li>
            <?php if(Session::get('role_id') == 1){ ?>
            <li><a href="{{ url('/inventory') }}"><span> Product Inventory Management</span></a></li>
            <li><a href="{{ url('product/report') }}"><span> Product Inventory Report</span></a></li>
            <?php }else{  ?>
            <li><a href="{{ url('/shopinventory') }}"><span> Product Inventory Management</span></a></li>
          <?php } ?>
          </ul>
        </li>


        <?php  if(Session::get('role_id') == 1){ ?>

          <li><a href="{{ url('/order') }}"><i class="fa fa-shopping-cart"></i> <span>Order Management</span></a></li>


        <?php }else{ ?>

          <li><a href="{{ url('/shoporder') }}"><i class="fa fa-shopping-cart"></i> <span>Order Management</span></a></li>

        <?php } ?>
        <!-- <li><a href="#"><i class="fa fa-money"></i> <span>Coupon Management</span></a></li> -->

      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->