@extends('Website.layouts.app')

@section('title', 'Product Management')
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
    Product <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="#">Product</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Product Management</h3>
          
          <span class="pull-right">
            <a class="btn btn-block btn-primary" href="{{url('product/create')}}">Add New + </a>
          </span>
          
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table  id="table" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Product Id</th>
              <th>Category Name</th>
              <th>Subcategory Name</th>
              <th>Product Name</th>
              <th>Brand Name</th>
              <th>Product Rate</th>
              <th>Created At</th>
              <th>Updated At</th>
              <th>Featured</th>
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

var index_url = "{{route('website.product.getrecord')}}";

$(function() {
    $('#table').DataTable({
      processing: true,
      serverSide: true,
      order: [[ 0, "desc" ]],
      ajax: index_url,
      columns: [
        { data: 'productId', name: 'productId'},
        { data: 'productcategoryname', name: 'productcategoryname'},
        { data: 'productsubcategoryname', name: 'productsubcategoryname'},
        { data: 'productname', name: 'productname'},
        { data: 'productbrand', name: 'productbrand'},
        { data: 'productrate', name: 'productrate'},
        { data: 'productcreatedat', name: 'productcreatedat'},
        { data: 'productupdatedat', name: 'productupdatedat'},
        { data: 'featured', name: 'featured'},
        { data: null,
          render: function(data){
            if(data.productstatus == 0){
              var label = '<label style="color:red"><b>Inactive</b></label>';
            }
            if(data.productstatus == 1){
              var label = '<label style="color:green"><b>Active</b></label>';
            }
            return label;
          }, orderable: "false"
        },
        { data: null,
          render: function(data){
            
            var text = "'Are You Sure to delete this record?'";
            var view_button = '<a href="{{url('product/display')}}/'+data.productId+'"><i class="fa fa-eye"></i></a>';

            if(data.roleid == 1)
            {
              var edit_button = ' <a href="{{url('product/edit')}}/'+data.productId+'"><i class="fa fa-edit"></i></a>';
              var delete_button = ' <a href="{{url('product/deleted')}}/'+data.productId+'" onclick="return window.confirm('+text+');"><i class="fa fa-trash" style="color:red"></i></a>';
            }
            if(data.roleid == 1)
            {            
              return view_button + edit_button + delete_button;
            }else{
              return view_button;

            }

          }, orderable: "false"
        },
      ]
    });
 });
</script>
@endpush 