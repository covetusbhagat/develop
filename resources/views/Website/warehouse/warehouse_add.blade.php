@extends('Website.layouts.app')

@section('title', 'Warehouse Management')
@section('meta_description', 'Online Rental Application')
@section('meta_author', 'Rentrotree')

@push('header_styles')


@endpush   

@push('header_script')
@endpush

@section('heading')
<h1>
    Warehouse <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ url('/warehouse') }}">Warehouse</a></li>
    <li><a href="#">Add Warehouse</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Add New Warehouse</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- /.box-header -->
        <div class="box-body">

            <form method="POST" action="{{url('warehouse/store')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group col-md-6">
                    <label for="">Werehouse Name</label> <span style="color:red"> *</span>
                    <input type="text" value="{{ old('warehouse_name') }}" required name="warehouse_name" class="form-control" placeholder="Werehouse Name">
                </div>
                <div class="row">
                    <div class="col-xs-12"></div>

                    <div class="col-xs-3">
                        <a class="btn btn-danger btn-close" href="{{URL::previous()}}">Cancel</a>
                    </div>
                    <div class="col-xs-3 pull-right">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
                    </div>
                </div>
            </form>
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