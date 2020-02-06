@extends('Website.layouts.app')

@section('title', 'Referral Management')
@section('meta_description', 'Online Rental Application')
@section('meta_author', 'Rentrotree')

@push('header_styles')

@endpush   

@push('header_script')
@endpush

@section('heading')
<h1>
    Referral <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ url('/referral') }}">Referral</a></li>
    <li><a href="#">Update Referral Coupon</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Update Referral Coupon</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- /.box-header -->
        <div class="box-body">

            <form method="POST" action="{{url('referral/update')}}/{{ $referral_record->id }}">
                @csrf
                <div class="form-group col-md-6">
                    <label for="">Referral code</label> <span style="color:red"> *</span>
                    <input type="text" name="referral_code" value="{{ $referral_record->referral_code }}" required class="form-control" placeholder="Referral code">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Referral Percentage</label> <span style="color:red"> *</span>
                    <input type="number" name="referral_percentage" value="{{ $referral_record->referral_percentage }}"  step="0.01" required class="form-control" placeholder="Referral Percentage">
                </div>
                <div class="form-group col-md-6">
                    <label for="">uses days</label> <span style="color:red"> *</span>
                    <input type="number" name="use_days" value="{{ $referral_record->use_days }}" required class="form-control" placeholder="uses days">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Maximum Limit</label> <span style="color:red"> *</span>
                    <input type="number" name="maximum_limit" value="{{ $referral_record->maximum_limit }}" step="0.01" required class="form-control" placeholder="Maximum Limit">
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