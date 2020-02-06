@extends('Website.layouts.app')

@section('title', 'Inventory Management')
@section('meta_description', 'Online Rental Application')
@section('meta_author', 'Rentrotree')

@push('header_styles')

    
@endpush   

@push('header_script')
@endpush

@section('heading')
<h1>
    Add Inventory <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ url('/shopinventory') }}">Inventory</a></li>
    <li><a href="#">Add Inventory</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Add New Inventory</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- /.box-header -->
        <div class="box-body">

            <form method="POST" action="{{url('shopinventory/store')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group col-md-6">
                    <label for="">Select Product</label>  <span style="color:red"> *</span>
                    <select id="product_id" name="product_id" class="form-control">
                        <option value="">Select Product</option>
                        @foreach ($product as $key=>$val)
                            <option value="{{ $val->id }}">{{ $val->product_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="">Total Quantity</label> <span style="color:red"> *</span>
                    <input type="number" name="total_quantity" required class="form-control" placeholder="Total Quantity">
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