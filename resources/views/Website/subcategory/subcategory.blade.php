@extends('Website.layouts.app')

@section('title', 'Subcategory Management')
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
    Subcategory <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="#">Subcategory</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Subcategory Management</h3>
          
          <span class="pull-right">
            <a class="btn btn-block btn-primary" href="{{url('subcategory/create')}}">Add New + </a>
          </span>
          
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table  id="table" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Subcategory Id</th>
              <th>Category Name</th>
              <th>Subcategory Name</th>
              <th>Subcategory Image</th>
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

var index_url = "{{route('website.subcategory.getData')}}";

$(function() {
    $('#table').DataTable({
      processing: true,
      serverSide: true,
      fixedHeader: true,
      ajax: index_url,
      columns: [
        { data: 'subcategoryId', name: 'subcategoryId'},
        { data: 'categoryName', name: 'categoryName'},
        { data: 'subcategoryName', name: 'subcategoryName'},
        { data: null,
          render: function(data){ 
            var label1 = '<img src="{{url('storage/app')}}/'+data.subcategoryImage+'" width="50px" height="auto" class="img-circle">';
            return label1;
          }, orderable: "false"
        },
        { data: 'subcategoryCreatedat', name: 'subcategoryCreatedat'},
        { data: 'subcategoryUpdatedat', name: 'subcategoryUpdatedat'},
        { data: null,
          render: function(data){
            if(data.subcategorystatus == 0){
              var label = '<label style="color:red"><b>Inactive</b></label>';
            }
            if(data.subcategorystatus == 1){
              var label = '<label style="color:green"><b>Active</b></label>';
            }
            return label;
          }, orderable: "false"
        },
        { data: null,
          render: function(data){
            
            var text = "'Are You Sure to delete this record?'";

            var edit_button = '<a href="{{url('subcategory/edit')}}/'+data.subcategoryId+'"><i class="fa fa-edit"></i></a>';
            var delete_button = ' <a href="{{url('subcategory/deleted')}}/'+data.subcategoryId+'" onclick="return window.confirm('+text+');"><i class="fa fa-trash" style="color:red"></i></a>';
            
            return edit_button + delete_button;
          }, orderable: "false"
        },
      ]
    });
 });
</script>
@endpush 