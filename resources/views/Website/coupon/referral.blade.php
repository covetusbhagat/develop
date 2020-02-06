@extends('Website.layouts.app')

@section('title', 'Referral Management')
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
    Referral <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ url('/referral') }}">Referral</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Referral Coupon Management</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table  id="table" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Referral Id</th>
              <th>Code</th>
              <th>Percentage</th>
              <th>Uses days</th>
              <th>Maximum limit</th>
              <th>Create At</th>
              <th>Update At</th>
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

@endsection

@push('footer_styles')
@endpush

@push('footer_script')

<script src="{{ url('admin/dist/js/jquery.dataTables.min.js') }}" defer></script>
<script type="text/javascript">

var index_url = "{{route('website.referral.getData')}}";

$(function() {
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: index_url,
        columns: [
          { data: 'id', name: 'id'},
          { data: 'referral_code', name: 'referral_code'},
          { data: 'referral_percentage', name: 'referral_percentage'},
          { data: 'use_days', name: 'use_days'},
          { data: 'maximum_limit', name: 'maximum_limit'},
          { data: 'created_at', name: 'created_at'},
          { data: 'updated_at', name: 'updated_at'},
          { data: null,
            render: function(data){
              var edit_button = '<a href="{{url('referral/edit')}}/'+data.id+'"><i class="fa fa-edit"></i></a>';
              return edit_button;
            }, orderable: "false"
          },
        ]
    });
 });
</script>

@endpush 