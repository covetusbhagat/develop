@extends('Website.layouts.app')

@section('title', 'Customer Management')
@section('meta_description', 'Online Rental Application')
@section('meta_author', 'Rentrotree')

@push('header_styles')

@endpush   

@push('header_script')
@endpush

@section('heading')
<h1>
    Delivery <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ url('/delivery') }}">Delivery</a></li>
    <li><a href="#">Update Delivery</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Update Delivery Boy</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- /.box-header -->
        <div class="box-body">

            <form method="POST" action="{{url('delivery/update')}}/{{ $user_record->id }}">
                @csrf
                <div class="form-group col-md-6">
                    <label for="">First Name</label> <span style="color:red"> *</span>
                    <input type="text" name="first_name" value="{{ $user_record->first_name }}" class="form-control" placeholder="First Name">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Last Name</label> <span style="color:red"> *</span>
                    <input type="text" name="last_name" value="{{ $user_record->last_name }}" class="form-control" placeholder="Last Name">
                </div>
                <!-- <div class="form-group col-md-6">
                    <label for="">Email</label> <span style="color:red"> *</span>
                    <input type="email" name="email" value="{{ $user_record->email }}" class="form-control" placeholder="Email">
                </div> -->
                <!-- <div class="form-group col-md-6">
                    <label for="">Mobile Number</label> <span style="color:red"> *</span>
                    <input type="number" name="mobile" value="{{ $user_record->mobile }}" class="form-control" placeholder="Mobile Number">
                </div> -->
                <div class="form-group col-md-6">
                    <label for="">Password</label>
                    <input type="password" name="set_password" value="" class="form-control" placeholder="password">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Update status</label>
                    <select name="status" class="form-control">
                        <option <?php if($user_record->status == 1){ echo "Selected"; } ?> value="1">Active</option>
                        <option <?php if($user_record->status == 0){ echo "Selected"; } ?> value="0">Inactive</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-xs-12"></div>

                    <div class="col-xs-3">
                        <a class="btn btn-danger btn-close" href="{{URL::previous()}}">Cancel</a>
                    </div>
                    <div class="col-xs-3 pull-right">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
@endsection

@push('footer_styles')
@endpush

@push('footer_script')

@endpush 