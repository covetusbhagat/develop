@extends('Website.layouts.app')

@section('title', 'Discount Management')
@section('meta_description', 'Online Rental Application')
@section('meta_author', 'Rentrotree')

@push('header_styles')

<link  href="{{ url('admin/dist/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ url('admin/bower_components/Ionicons/css/ionicons.min.css') }}">


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
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Discount Coupon Management</h3>

          <span class="pull-right">
            <a class="btn btn-block btn-primary" href="{{url('discount/create')}}">Add New + </a>
          </span>

        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table  id="table" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Coupon Id</th>
              <th>Coupon code</th>
              <th>Start date</th>
              <th>End date</th>
              <th>Coupon percentage</th>
              <th>Coupon uses time</th>
              <th>Maximum limit</th>
              <th>Created At</th>
              <th>Action</th>
            </tr>
            </thead>

            
            
          </table>
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

<script src="{{ url('admin/dist/js/jquery.dataTables.min.js') }}" defer></script>

<script type="text/javascript">

var index_url = "{{route('website.discount.getrecord')}}";

$(function() {
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: index_url,
        columns: [
          { data: 'id', name: 'id'},
          { data: 'coupon_code', name: 'coupon_code'},
          { data: 'start_date', name: 'start_date'},
          { data: 'end_date', name: 'end_date'},
          { data: 'coupon_percentage', name: 'coupon_percentage'},
          { data: 'coupon_uses_time', name: 'coupon_uses_time'},
          { data: 'maximum_limit', name: 'maximum_limit'},
          { data: 'created_at', name: 'created_at'},
          { data: null,
            render: function(data){
              var text = "'Are You Sure to delete this record?'";
              var edit_button = '<a href="{{url('discount/edit')}}/'+data.id+'"><i class="fa fa-edit"></i></a>';
              var delete_button = ' <a href="{{url('discount/deleted')}}/'+data.id+'" onclick="return window.confirm('+text+');"><i class="fa fa-trash" style="color:red"></i></a>';
              return  edit_button + delete_button;
            }, orderable: "false"
          },
        ]
    });
 });

</script>

@endpush 