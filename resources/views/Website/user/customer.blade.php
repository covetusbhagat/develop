@extends('Website.layouts.app')

@section('title', 'Customer Management')
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
    Customer <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="#">Customer</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Customer Management</h3>
          
          <span class="pull-right">
            <a class="btn btn-block btn-primary" href="{{url('customer/create')}}">Add New + </a>
          </span>
          
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table  id="table" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>UserId</th>
              <th>Name</th>
              <th>Email</th>
              <th>Mobile</th>
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

var index_url = "{{route('website.customer.getData')}}";

$(function() {
    $('#table').DataTable({
      processing: true,
      serverSide: true,
      ajax: index_url,
      columns: [
        { data: 'id', name: 'id'},
        { data: 'fullname', name: 'fullname'},
        { data: 'email', name: 'email'},
        { data: 'mobile', name: 'mobile'},
        { data: 'created_at', name: 'created_at'},
        { data: 'updated_at', name: 'updated_at'},
        { data: 'doc_aprove', name: 'doc_aprove'},
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

            var text = "'Are You Sure to delete this record?'";

            var show_button = '<a href="{{url('customer/display')}}/'+data.id+'"><i class="fa fa-eye"></i></a>';
            var edit_button = ' <a href="{{url('customer/edit')}}/'+data.id+'"><i class="fa fa-edit"></i></a>';
            var delete_button = ' <a href="{{url('customer/deleted')}}/'+data.id+'" onclick="return window.confirm('+text+');"><i class="fa fa-trash" style="color:red"></i></a>';
            
            return show_button + edit_button + delete_button;
          }, orderable: "false"
        },
      ]
    });
 });
</script>
@endpush 