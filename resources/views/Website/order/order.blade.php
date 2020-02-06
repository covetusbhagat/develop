@extends('Website.layouts.app')

@section('title', 'Order Management')
@section('meta_description', 'Online Rental Application')
@section('meta_author', 'Rentrotree')

@push('header_styles')

<link  href="{{ url('admin/dist/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ url('admin/bower_components/Ionicons/css/ionicons.min.css') }}">
<style>
  .dataTables_wrapper{
    width: 100%;overflow-x: scroll;
  }
</style> 

@endpush   

@push('header_script')
@endpush

@section('heading')
<h1>
    Order <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="#">Order</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Order Management</h3>  
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table  id="table" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>OrderId</th>
              <th>Customer Name</th>
              <th>Product Name</th>
              <th>Estimate_Start_Date</th>
              <th>Estimate_End_Date</th>
              <th>Apply Rate</th>
              <th>Delivery Type</th>
              <th>First Amount</th>
              <th>Created At</th>
              <th>Update At</th>
              <th>Doc_approve</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
            </thead>

          </table>
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

var index_url = "{{route('website.order.getData')}}";

$(function() {
    $('#table').DataTable({
      processing: true,
      serverSide: true,
      ajax: index_url,
      columns: [
        { data: 'id', name: 'id'},
        { data: 'Customerfullname', name: 'Customerfullname'},
        { data: 'ProductName', name: 'ProductName'},
        { data: 'estimate_start_datetime', name: 'estimate_start_datetime'},
        { data: 'estimate_end_datetime', name: 'estimate_end_datetime'},
        { data: 'apply_rate', name: 'apply_rate'},
        { data: 'delivery_type_status', name: 'delivery_type_status'},
        { data: 'first_amount', name: 'first_amount'},
        { data: 'created_at', name: 'created_at'},
        { data: 'updated_at', name: 'updated_at'},
        { data: 'doc_aprove', name: 'doc_aprove'},
        { data: null,
          render: function(data){
            if(data.status == 1){
              var label = '<label style="color:green"><b>Order</b></label>';
            }
            if(data.status == 2){
              var label = '<label style="color:green"><b>In-transist</b></label>';
            }
            if(data.status == 3){
              var label = '<label style="color:green"><b>Deliverd</b></label>';
            }
            if(data.status == 4){
              var label = '<label style="color:green"><b>Return Initiated</b></label>';
            }
            if(data.status == 5){
              var label = '<label style="color:green"><b>Completed</b></label>';
            }
            if(data.status == 6){
              var label = '<label style="color:green"><b>Cancelled</b></label>';
            }
            if(data.status == 7){
              var label = '<label style="color:green"><b>Resume order</b></label>';
            }
            if(data.status == 8){
              var label = '<label style="color:green"><b>Resume return initiated</b></label>';
            }
            if(data.status == 9){
              var label = '<label style="color:green"><b>Lost product</b></label>';
            }
            if(data.status == 10){
              var label = '<label style="color:green"><b>Damage Product</b></label>';
            }
            return label;
          }, orderable: "false"
        },
        { data: null,
          render: function(data){

            var text = "'Are You Sure to delete this record?'";

            var show_button = '<a href="{{url('order/display')}}/'+data.id+'"><i class="fa fa-eye"></i></a>';
            var delete_button = ' <a href="#" onclick="return window.confirm('+text+');"><i class="fa fa-trash" style="color:red"></i></a>';
            
            return show_button + delete_button;
          }, orderable: "false"
        },
      ]
    });
 });
</script>
@endpush 