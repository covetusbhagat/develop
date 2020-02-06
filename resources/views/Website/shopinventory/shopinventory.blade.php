@extends('Website.layouts.app')

@section('title', 'Inventory Management')
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
    Inventory <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="#">Inventory</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Inventory Management</h3>
          
          <span class="pull-right">
            <a class="btn btn-block btn-primary" href="{{url('shopinventory/create')}}">Add New + </a>
          </span>
          
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table  id="table" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Id</th>
              <th>Shopkeeper Name</th>
              <th>Product Name</th>
              <th>Total Count</th>
              <th>Lost</th>
              <th>damage</th>
              <th>OnRent</th>
              <th>Available</th>
              <th>Created At</th>
              <th>Updated At</th>
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

var index_url = "{{route('website.shopinventory.getdata')}}";

$(function() {
    $('#table').DataTable({
      processing: true,
      serverSide: true,
      ajax: index_url,
      columns: [
        { data: 'id', name: 'id'},
        { data: 'shopkeeperfullname', name: 'shopkeeperfullname'},
        { data: 'productname', name: 'productname'},
        { data: 'total_quantity', name: 'total_quantity'},
        { data: 'lost_quantity', name: 'lost_quantity'},
        { data: 'damage_quantity', name: 'damage_quantity'},
        { data: 'on_rent_quantity', name: 'on_rent_quantity'},
        { data: 'available_quantity', name: 'available_quantity'},
        { data: 'created_at', name: 'created_at'},
        { data: 'updated_at', name: 'updated_at'},
        { data: null,
          render: function(data){
            if(data.status == 0){
              var label = '<label style="color:red"><b>Inactive</b></label>';
            }
            if(data.status == 1){
              var label = '<label style="color:green"><b>Active</b></label>';
            }
            return label;
          }, orderable: "false"
        },
        { data: null,
          render: function(data){
            
            var view_button = '<a href="{{url('shopinventory/display')}}/'+data.id+'"><i class="fa fa-eye"></i></a>';
            var edit_button = ' <a href="{{url('shopinventory/edit')}}/'+data.id+'"><i class="fa fa-edit"></i></a>';
            
            return view_button + edit_button;
          }, orderable: "false"
        },
      ]
    });
 });
</script>
@endpush 