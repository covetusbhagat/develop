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
    Update Inventory <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ url('/shopinventory') }}">inventory</a></li>
    <li><a href="#">Update Inventory</a></li>
</ol>
@endsection

@section('content')
  

    <div class="row">
        <div class="col-xs-12"> 
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Update Status Inventory</h3>
            </div>
            <!-- /.box-header -->
            
            <!-- /.box-header -->
            <div class="box-body">

                <form method="POST" action="{{url('shopinventory/update')}}/{{ $inventory_record->id }}">
                    @csrf
                    
                    <div class="form-group col-md-6">
                        <label for="">Update status</label>
                        <select name="status" class="form-control">
                            <option <?php if($inventory_record->status == 1){ echo "Selected"; } ?> value="1">Active</option>
                            <option <?php if($inventory_record->status == 0){ echo "Selected"; } ?> value="0">Inactive</option>
                        </select>
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




    <div class="row">
        <div class="col-xs-12"> 
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Update Inventory</h3>
            </div>
            <!-- /.box-header -->
            
            <!-- /.box-header -->
            <div class="box-body">

                <form method="POST" action="{{url('shopinventory/update_quantity')}}/{{ $inventory_record->id }}">
                    @csrf
                    <div class="form-group col-md-6">
                        <label for="">Quantity</label> <span style="color:red"> *</span>
                        <input type="number" name="quantity" required class="form-control" placeholder="">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="">Opration Type</label>  <span style="color:red"> *</span>
                        <select name="opration" class="form-control">
                            <option value="">Select Opration</option>
                            <option value="2">Lost Inventory</option>
                            <option value="3">Damage Inventory</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6"></div>
                    <div class="row">
                        <div class="col-xs-9"></div>
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