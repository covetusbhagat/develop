@extends('Website.layouts.app')

@section('title', 'Profile')
@section('meta_description', 'Online Rental Application')
@section('meta_author', 'Rentrotree')

@push('header_styles')
@endpush   

@push('header_script')
@endpush

@section('heading')
<h1>
    Profile <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="#">Profile</a></li>
</ol>
@endsection

@section('content')

  <div id="msg"></div>
  <!-- Default box -->

  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Profile Update</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">
      <form method="POST" action="{{url('profile/update')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group col-md-6">
            <label for="">First Name</label> <span style="color:red"> *</span>
            <input type="text" name="first_name" value="{{ $user_record->first_name }}" required class="form-control" placeholder="First Name">
        </div>
        <div class="form-group col-md-6">
            <label for="">Last Name</label> <span style="color:red"> *</span>
            <input type="text" name="last_name" value="{{ $user_record->last_name }}" required class="form-control" placeholder="Last Name">
        </div>
        <div class="form-group col-md-6">
                  <img src="{{url('storage/app')}}/{{session('profile_image')}}" width="200px" height="200px" class="img-circle" alt="User Image">
           <!-- <img src="{{url('storage/app')}}/{{session('profile_image')}}" width="200px" height="200px" class="img-circle" alt="User Image"> -->
        </div>
        <div class="form-group col-md-6">
          
          <?php if($user_record->doc_image != ""){ ?>
            <img src="{{url('storage/app')}}/{{$user_record->doc_image}}" width="300px" height="200px" alt="User Document Image">
          <?php  }else{ ?>
            <img src="{{url('storage/app/doc_image')}}/default.jpg" width="300px" height="200px" alt="User Document Image">
          <?php  } ?>

        </div>
        <div class="form-group col-md-6">
            <label for="">Update Profile Image</label>
            <input type="file" name="profile_image">
        </div>
        <div class="form-group col-md-6">
            <label for="">Update Document Image</label>
            <input type="file" name="doc_image">
        </div>
        <div class="row">
            <div class="col-xs-9"></div>
            
            <div class="col-xs-3 pull-right">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
            </div>
        </div>
    </form>
    </div>
    <!-- /.box-body -->

    <!-- /.box-footer-->
  </div>
  <!-- /.box -->

  

<?php if(Session::get('role_id') != 1){ ?>
  <!-- Default box -->
  <div class="box collapsed-box">
    <div class="box-header with-border">
      <h3 class="box-title">View Address</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">

      @foreach ($address_list as $key=>$val)

        <div class="form-group col-md-4">
            <label for="">House/Shop Number</label> : {{ $val->house_no }}
        </div>

        <div class="form-group col-md-8">
            <label for="">Land mark</label> : {{ $val->land_mark }}
        </div>

        <div class="form-group col-md-4">
          <label for="">State</label> : {{ $val->state_name }}
        </div>

        <div class="form-group col-md-4">
          <label for="">City</label> : {{ $val->city_name }}
        </div>

        <div class="form-group col-md-4">
          <label for="">Pincode</label> : {{ $val->pincode }} 
        </div>

        <div class="form-group col-md-6">
          <label for="">Latitude</label> : {{ $val->latitude }}
        </div>

        <div class="form-group col-md-6">
          <label for="">Longitude</label> : {{ $val->longitude }}
        </div>

        <div class="form-group col-md-12">
          <hr/>
        </div>        

      @endforeach
    
    </div>
    <!-- /.box-body -->
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->

<?php } ?>

  <!-- Default box -->
  <div class="box collapsed-box">
    <div class="box-header with-border">
      <h3 class="box-title">Reset Password</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">
      <form method="POST" action="{{url('profile/reset_password')}}" onsubmit="return ValidateForm();">
        @csrf
        
        <div class="form-group col-md-7">
            <label for="">Old Password</label> <span style="color:red"> *</span>
            <input type="password" name="old_password" required class="form-control" placeholder="Old Password">
        </div>
        <div class="form-group col-md-7">
            <label for="">New Password</label> <span style="color:red"> *</span>
            <input type="password" name="new_password" id="new_password" required class="form-control" placeholder="New Password">
        </div>
        <div class="form-group col-md-7">
            <label for="">Conform Password</label> <span style="color:red"> *</span>
            <input type="password" name="conform_password" id="conform_password" required class="form-control" placeholder="Conform Password">
        </div>
        
        <div class="row">
            <div class="col-xs-9"></div>
            <div class="col-xs-3 pull-left">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
            </div>
        </div>
    </form>
    </div>
    <!-- /.box-body -->
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->




@endsection

@push('footer_styles')
@endpush

@push('footer_script')

<script type="text/javascript">
  function ValidateForm(){
    
      var password = $("#new_password").val();
      var confirm_password = $("#conform_password").val();
      
      if(password != confirm_password){
        $("#msg").html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Confirm password does not match.</strong></div>');
        return false;
      }
  }
</script>

<script type="text/javascript">
    $('#state_id').change(function(){
    var stateID = $(this).val();    
    if(stateID){
        $.ajax({
           type:"GET",
           url:"{{url('api/get_city_list')}}/"+stateID,
           success:function(res){               
            if(res){
                $("#city_id").empty();
                $.each(res,function(id,city_name){
                    $("#city_id").append('<option value="'+id+'">'+city_name+'</option>');
                });
           
            }else{
               $("#city_id").empty();
            }
           }
        });
    }else{
        $("#city_id").empty();
    }      
    });
</script>



@endpush