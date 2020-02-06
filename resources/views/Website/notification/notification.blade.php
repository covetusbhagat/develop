@extends('Website.layouts.app')

@section('title', 'Notification Management')
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
    Notification <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="#">Notification</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Notification Management</h3>
          
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table  id="table" class="table table-bordered table-striped">
            <thead>
            <tr>              
              <th>Massage</th>
              <th>Created At</th>
              <th>Updated At</th>
              <th>Status</th>
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

var index_url = "{{route('website.notification.getData')}}";

$(function() {
    $('#table').DataTable({
      processing: true,
      serverSide: true,
      order: [[ 1, "desc" ]],
      ajax: index_url,
      columns: [
        { data: null,
          render: function(data){ 
            var label1 = '<a href="'+data.displaylink+'" >'+data.massage+'</a>';
            return label1;
          }, orderable: "false"
        },
        { data: 'created_at', name: 'created_at'},
        { data: 'updated_at', name: 'updated_at'},
        { data: null,
          render: function(data){
            if(data.status == 0){
              var label = '<label style="color:red"><b>Read</b></label>';
            }
            if(data.status == 1){
              var label = '<label style="color:green"><b>Not Read</b></label>';
            }
            return label;
          }, orderable: "false"
        },
      ]
    });
 });
</script>
@endpush 