@extends('Website.layouts.app')

@section('title', 'Complain Management')
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
    Complain <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="#">Complain</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Complain Management</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table  id="table" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Complain Id</th>
              <th>Customer Id</th>
              <th>Customer name</th>
              <th>Complain subject</th>
              <th>Complain message</th>
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

var index_url = "{{route('website.complain.getData')}}";

$(function() {
    $('#table').DataTable({
      processing: true,
      serverSide: true,
      ajax: index_url,
      columns: [
        { data: 'id', name: 'id'},
        { data: 'complaint_by', name: 'complaint_by'},
        { data: 'customerfullname', name: 'customerfullname'},
        { data: 'subject', name: 'subject'},
        { data: 'complaint_text', name: 'complaint_text'},
        { data: 'created_at', name: 'created_at'},
        { data: 'updated_at', name: 'updated_at'},
        { data: null,
          render: function(data){
            if(data.status == 0){
              var label = '<label style="color:red"><b>Reject</b></label>';
            }
            if(data.status == 1){
              var label = '<label style="color:orange"><b>Open/Processing</b></label>';
            }
            if(data.status == 2){
              var label = '<label style="color:green"><b>Resolved by admin</b></label>';
            }
            if(data.status == 3){
              var label = '<label style="color:blue"><b>Close by customer</b></label>';
            }
            return label;
          }, orderable: "false"
        },
        { data: null,
          render: function(data){

            var text = "'Are You Sure to delete this record?'";

            var view_button = '<a href="{{url('complain/display')}}/'+data.id+'"><i class="fa fa-eye"></i></a>';
            var edit_button = ' <a href="{{url('complain/edit')}}/'+data.id+'"><i class="fa fa-edit"></i></a>';
            var delete_button = ' <a href="{{url('complain/deleted')}}/'+data.id+'" onclick="return window.confirm('+text+');"><i class="fa fa-trash" style="color:red"></i></a>';
            
            return view_button + edit_button + delete_button;
          }, orderable: "false"
        },
      ]
    });
 });
</script>
@endpush 