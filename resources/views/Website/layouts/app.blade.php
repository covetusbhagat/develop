<!DOCTYPE html>

<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>@yield('title', 'RentoTree')</title>

  <meta name="description" content="@yield('meta_description', 'Online Rental Application')">
  <meta name="author" content="@yield('meta_author', 'ERipples Infomatices PVT. LTD.')">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="{{ url('admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ url('admin/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ url('admin/bower_components/Ionicons/css/ionicons.min.css') }}">
  <link rel="stylesheet" href="{{ url('admin/dist/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ url('admin/dist/css/skins/skin-blue.min.css') }}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  @stack('header_styles')
  @stack('header_script')

</head> 

<body class="skin-blue sidebar-mini fixed">
<div class="wrapper">

  <!-- Main Header -->

  @include('Website.includes.header')
  
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    @include('Website.includes.sidebar')
    
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
    <section class="content-header">
      @yield('heading')
      @yield('breadcrumb')
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

    <!-- Main content -->
    <section class="content">
      @include('Website.flash-message')
      @yield('content')
    </section>
    
    <!-- /.content -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('Website.includes.footer')

  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->

  @include('Website.includes.aside')
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<!-- REQUIRED JS SCRIPTS -->
<!-- jQuery 3 -->

  <script type="text/javascript">
    setTimeout(function() {
      $('#myalert').fadeOut('fast');
    }, 5000); // <-- time in milliseconds
  </script>

  <script src="{{ url('admin/bower_components/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ url('admin/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <script src="{{ url('admin/dist/js/adminlte.min.js') }}"></script>

<script type="text/javascript">

  get_notification_details();
  get_chat_user();
    
    function get_notification_details(){
      var get_url = "{{url('get_notification')}}";
      $.ajax(
        {
          type: "POST",
          url: get_url,
          data: {  _token :' {{ csrf_token()}}'},
          async: false,
          success: function(data)
          {
            var datas= jQuery.parseJSON(data.results);
            for(var i=0;i<datas.length;i++)
            {
              noti='<li><a href="'+datas[i].displaylink+'"><i class="fa fa-bell"></i>'+datas[i].massage+'</a></li>';
             $("#all_notifications").append(noti);
             $(".head_noti").html(datas.length);
            }
          }
        }
      );
    }     

    function get_chat_user(){
      var chat_url = "{{url('get_chat_user')}}";
      $.ajax(
        {
          type: "POST",
          url: chat_url,
          data: {  _token :' {{ csrf_token()}}'},
          async: false,
          success: function(data)
          { 
            var datas= jQuery.parseJSON(data.results);
            if(datas.length != 0){
              for(var i=0;i<datas.length;i++)
              {
                
                chat='<li><a href="{{url('chat')}}/'+datas[i].sender_id+'" style="padding: 2px 15px;"><i><img src="{{url('storage/app')}}/'+datas[i].profile_image+'" class="img-circle" width="40" height="40" alt="User Image"></i><div class="" style="display: inline-block;vertical-align: middle; margin-left:10px;"><span style="margin-top:10px;" class="control-sidebar-subheading">'+datas[i].first_name+' '+datas[i].last_name+'</span><p>'+datas[i].message+'</p></div></a></li>';

                chat_count=datas.length;
               $("#all_users").append(chat);
               $("#chat_count").html(chat_count);
              }
            }else{
              chat='<span><p class="text-center">No Message..</p></span>';

              chat_count="";
              $("#all_users").append(chat);
              $("#chat_count").html(chat_count);
            }
          }
        }
      );
    }
  </script>



  @stack('footer_styles')
  @stack('footer_script')

</body>
</html>