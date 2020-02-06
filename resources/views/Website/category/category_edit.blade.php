@extends('Website.layouts.app')

@section('title', 'Category Management')
@section('meta_description', 'Online Rental Application')
@section('meta_author', 'Rentrotree')

@push('header_styles')

@endpush   

@push('header_script')
@endpush

@section('heading')
<h1>
    Category <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ url('/category') }}">Category</a></li>
    <li><a href="#">Update Category</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Update Category</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- /.box-header -->
        <div class="box-body">

            <form method="POST" action="{{url('category/update')}}/{{ $category_record->id }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group col-md-6">
                    <label for="">Category Name</label> <span style="color:red"> *</span>
                    <input type="text" name="category_name" value="{{ $category_record->category_name }}" class="form-control" placeholder="Category Name">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Update status</label>
                    <select name="status" class="form-control">
                        <option <?php if($category_record->status == 1){ echo "Selected"; } ?> value="1">Active</option>
                        <option <?php if($category_record->status == 0){ echo "Selected"; } ?> value="0">Inactive</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="">Category Image</label>
                    <input type="file" name="category_image">
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