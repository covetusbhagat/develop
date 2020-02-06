@extends('Website.layouts.app')

@section('title', 'Subcategory Management')
@section('meta_description', 'Online Rental Application')
@section('meta_author', 'Rentrotree')

@push('header_styles')

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
    <li><a href="{{ url('/subcategory') }}">Subcategory</a></li>
    <li><a href="#">Update Subcategory</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Update Subcategory</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- /.box-header -->
        <div class="box-body">

            <form method="POST" action="{{url('subcategory/update')}}/{{ $subcategory_record->id }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group col-md-6">
                    <label for="">Select Category</label> <span style="color:red"> *</span>
                    <select name="category_id" class="form-control">
                        @foreach ($category_record as $key=>$val)
                                <option <?php if($subcategory_record->category_id == $val->id){ echo "selected"; } ?>  value="{{ $val->id }}">{{ $val->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group col-md-6">
                    <label for="">Subcategory Name</label> <span style="color:red"> *</span>
                    <input type="text" name="subcategory_name" required class="form-control" placeholder="Subcategory Name" value="{{ $subcategory_record->subcategory_name }}">
                </div> 

                <div class="form-group col-md-6">
                    <label for="">Update status</label>
                    <select name="status" class="form-control">
                        <option <?php if($subcategory_record->status == 1){ echo "Selected"; } ?> value="1">Active</option>
                        <option <?php if($subcategory_record->status == 0){ echo "Selected"; } ?> value="0">Inactive</option>
                    </select>
                </div>


                <div class="form-group col-md-6">
                    <label for="">Subategory Image</label>
                    <input type="file" name="subcategory_image">
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