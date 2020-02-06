@extends('Website.layouts.app')

@section('title', 'Discount Management')
@section('meta_description', 'Online Rental Application')
@section('meta_author', 'Rentrotree')

@push('header_styles')
@endpush   

@push('header_script')
@endpush

@section('heading')
<h1>
    Discount <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ url('/discount') }}">Discount</a></li>
    <li><a href="#">Add Discount Coupon</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Add New Discount Coupon</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- /.box-header -->
        <div class="box-body">
            <div class="overlay" id="page_loader" style="display:none;">
                <i class="fa fa-refresh fa-spin"></i>
              </div>

            <form method="POST" action="{{url('discount/store')}}">

                @csrf
                <div class="form-group col-md-6">
                    <label for="">Coupon Code</label> <span style="color:red"> *</span>
                    <input type="text" value="{{ old('coupon_code') }}" name="coupon_code" required class="form-control" placeholder="Coupon Code">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Coupon Uses Time</label> <span style="color:red"> *</span>
                    <input type="number" value="{{ old('coupon_uses_time') }}" name="coupon_uses_time" required class="form-control" placeholder="Coupon Uses Time">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Start Date</label> <span style="color:red"> *</span>
                    <input id="start_date" type="date" value="{{ old('start_date') }}" name="start_date" required class="form-control" placeholder="Start Date" onchange="end_date_limitation()" min="<?=date("Y-m-d");?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="">End Date</label> <span style="color:red"> *</span>
                    <input id="end_date" type="date" value="{{ old('end_date') }}" name="end_date" required class="form-control" placeholder="End Date"
                    min="<?=date("Y-m-d");?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Coupon Percentage</label> <span style="color:red"> *</span>
                    <input type="number" value="{{ old('coupon_percentage') }}" name="coupon_percentage"  step="0.01" required class="form-control" placeholder="Coupon Percentage">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Maximum Limit</label> <span style="color:red"> *</span>
                    <input type="number" value="{{ old('maximum_limit') }}" name="maximum_limit" step="0.01" required class="form-control" placeholder="Maximum Limit">
                </div>
                <div class="row">
                    <div class="col-xs-12"></div>

                    <div class="col-xs-3">
                        <a class="btn btn-danger btn-close" href="{{URL::previous()}}">Cancel</a>
                    </div>
                    <div class="col-xs-3 pull-right">
                        <button id="add_coupan" type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
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
<script type="text/javascript">
    function end_date_limitation(){
        var start_date = $("#start_date").val();
        $("#end_date").attr("min",start_date);
    }

    $("#add_coupan").click(function(){
        var isValid = true;
          $('.form-control').each(function() {
            if ( $(this).val() === '' )
                isValid = false;
          });
          if(isValid == true){
        $("#page_loader").css("display","block");
    }
       
    });
</script>
@endpush 