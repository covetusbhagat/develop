@extends('Website.layouts.app')

@section('title', 'Order Management')
@section('meta_description', 'Online Rental Application')
@section('meta_author', 'Rentrotree')

@push('header_styles')

    
@endpush   

@push('header_script')
@endpush

@section('heading')
<h1>
    Start order <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ url('/shoporder') }}">Order</a></li>
    <li><a href="#">Shoporder</a></li>
</ol>
@endsection

@section('content')
  

    <div class="row">
        <div class="col-xs-12"> 
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Start Shop Order</h3>
            </div>
            <!-- /.box-header -->
            
            <!-- /.box-header -->
            <div class="box-body">

                <form method="POST" action="{{url('shoporder/delivery_process')}}/{{ $order_detail->id }}">
                    @csrf
                    
                    
                    <div class="form-group col-md-6">
                         <label for="">Enter 4 Digit OTP</label> <span style="color:red"> *</span>
                        <input type="numeric" name="order_otp" required class="form-control" placeholder="4 digit OTP">
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