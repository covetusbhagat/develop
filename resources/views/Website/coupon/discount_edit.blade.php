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
    <li><a href="#">Update Discount</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Update Discount Coupon</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- /.box-header -->
        <div class="box-body">

            <form method="POST" action="{{url('discount/update')}}/{{ $discount_record->id }}">
                @csrf
                <!-- <div class="form-group col-md-6">
                    <label for="">Coupon Code</label> <span style="color:red"> *</span>
                    <input type="text" name="coupon_code" value="{{ $discount_record->coupon_code }}" required class="form-control" placeholder="Coupon Code">
                </div> -->
                <!-- <div class="form-group col-md-6">
                    <label for="">Coupon Uses Time</label> <span style="color:red"> *</span>
                    <input type="number" name="coupon_uses_time" value="{{ $discount_record->coupon_uses_time }}" required class="form-control" placeholder="Coupon Uses Time">
                </div> -->
                <div class="form-group col-md-6">
                    <label for="">Start Date</label> <span style="color:red"> *</span>
                    <input type="date" id="start_date" name="start_date" value="{{ $discount_record->start_date }}" required class="form-control" placeholder="Start Date" onchange="end_date_limitation()">
                </div>
                <div class="form-group col-md-6">
                    <label for="">End Date</label> <span style="color:red"> *</span>
                    <input type="date" id="end_date" name="end_date" value="{{ $discount_record->end_date }}" required class="form-control" placeholder="End Date" min="<?=date("Y-m-d");?>">
                </div>
                <!-- <div class="form-group col-md-6">
                    <label for="">Coupon Percentage</label> <span style="color:red"> *</span>
                    <input type="number" name="coupon_percentage" value="{{ $discount_record->coupon_percentage }}"  step="0.01" required class="form-control" placeholder="Coupon Percentage">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Maximum Limit</label> <span style="color:red"> *</span>
                    <input type="number" name="maximum_limit" value="{{ $discount_record->maximum_limit }}" step="0.01" required class="form-control" placeholder="Maximum Limit">
                </div> -->
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
<script type="text/javascript">
    function end_date_limitation(){
        var start_date = $("#start_date").val();
        $("#end_date").attr("min",start_date);
    }
</script>
@endpush 