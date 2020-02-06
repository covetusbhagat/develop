@extends('Website.layouts.app')

@section('title', 'RentoTree | Dashboard' )
@section('meta_description', 'Online Rental Application')
@section('meta_author', 'ERipples Infomatices PVT. LTD.')

@push('header_styles')
@endpush   

@push('header_script')
@endpush

@section('heading')
<h1>
    Dashboard, Welcome {{ Auth::user()->first_name }}
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
</ol>
@endsection

@section('content')
<div class="row">

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="ion ion-ios-list-outline"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Available Product</span>
          <span class="info-box-number">100</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="ion ion-ios-list-outline"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Lost Product</span>
          <span class="info-box-number">41,410</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="ion ion-ios-list-outline"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Damage Product</span>
          <span class="info-box-number">41,410</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="ion ion-ios-list-outline"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">On-Rent Product</span>
          <span class="info-box-number">2,000</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <?php if(Session::get('role_id') == 1){ ?> 

    <div class="col-md-12">
      <!-- Bar chart -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <i class="fa fa-balance-scale"></i>

          <h3 class="box-title">Complain Chart</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div id="bar-chart" style="height: 300px;"></div>
        </div>
        <!-- /.box-body-->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  <?php } ?>
</div>
<!-- /.row -->
@endsection

@push('footer_styles')
@endpush

@push('footer_script')
<!-- FLOT CHARTS -->

<?php if(Session::get('role_id') == 1)
{ 
  $chart_Complain = $data['complain'];
} ?>
<script src="{{ url('admin/bower_components/Flot/jquery.flot.js') }}"></script>
<script src="{{ url('admin/bower_components/Flot/jquery.flot.categories.js') }}"></script>

<?php if(Session::get('role_id') == 1){ ?> 
<script>
  $(function () {

    /*
     * BAR CHART
     * ---------
     */
    var chart_data = <?php echo json_encode($chart_Complain );?>;
    var bar_data = {
      data : chart_data,
      color: '#ff0000'
    }
    $.plot('#bar-chart', [bar_data], {
      grid  : {
        borderWidth: 1,
        borderColor: '#000000',
        tickColor  : '#f3f3f3'
      },
      series: {
        bars: {
          show    : true,
          barWidth: 0.5,
          align   : 'center'
        }
      },
      xaxis : {
        mode      : 'categories',
        tickLength: 0
      }
    })
    /* END BAR CHART */
  })

</script>

<?php } ?>

@endpush 