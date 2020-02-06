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
    Customer <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ url('/customer') }}">Customer</a></li>
    <li><a href="#">Add Customer</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Add New Customer</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- /.box-header -->
        <div class="box-body">

            <form method="POST" action="{{url('customer/store')}}">
                @csrf
                <div class="form-group col-md-6">

                    <label for="">First Name</label> <span style="color:red"> *</span>
                    <input type="text" value="{{ old('first_name') }}" required name="first_name" class="form-control" placeholder="First Name">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Last Name</label> <span style="color:red"> *</span>
                    <input type="text" value="{{ old('last_name') }}" required name="last_name" class="form-control" placeholder="Last Name">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Email</label> <span style="color:red"> *</span>
                    <input type="email" value="{{ old('email') }}" name="email" required class="form-control" placeholder="Email">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Mobile Number</label> <span style="color:red"> *</span>
                    <input type="number" value="{{ old('mobile') }}" name="mobile" required class="form-control" placeholder="Mobile Number">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Password</label> <span style="color:red"> *</span>
                    <input type="password" name="password" class="form-control" required placeholder="password">
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