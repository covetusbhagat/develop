@extends('Website.layouts.app')

@section('title', 'Complain Management')
@section('meta_description', 'Online Rental Application')
@section('meta_author', 'Rentrotree')

@push('header_styles')


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
    <li><a href="{{ url('/complain') }}">Complain</a></li>
    <li><a href="#">View complain detail</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">View Complain</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- /.box-header -->
        <div class="box-body">
            
            <div class="col-md-12">
                
                <table class="table table-hover table-bordered">
                    <tr>
                      <th>Title</th>
                      <th>Detail</th>
                    </tr>
                    <tr>
                      <td><b>Customer Id</b></td>
                      <td>{{ $complain_record->complaint_by }}</td>
                    </tr>
                    <tr>
                      <td><b>Customer Name</b></td>
                      <td>{{ $complain_record->customerfirstname }} {{ $complain_record->customerlastname }}</td>
                    </tr>
                    <tr>
                      <td><b>Subject</b></td>
                      <td>{{ $complain_record->subject }}</td>
                    </tr>
                    <tr>
                      <td><b>Message</b></td>
                      <td>{{ $complain_record->complaint_text }}</td>
                    </tr>
                    <tr>
                      <td><b>Created At</b></td>
                      <td>{{ $complain_record->created_at }}</td>
                    </tr>
                    <tr>
                      <td><b>Updated At</b></td>
                      <td>{{ $complain_record->updated_at }}</td>
                    </tr>
                    <tr>
                      <td><b>Status</b></td>
                      <td><?php if($complain_record->status == 0){ echo '<label style="color:red"><b>Reject</b></label>'; } ?><?php if($complain_record->status == 1){ echo '<label style="color:orange"><b>Open/Processing</b></label>'; } ?><?php if($complain_record->status == 2){ echo '<label style="color:green"><b>Resolved by admin</b></label>'; } ?><?php if($complain_record->status == 3){ echo '<label style="color:blue"><b>Close by customer</b></label>'; } ?></td>
                    </tr>
                </table>
            </div>

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

@endpush 