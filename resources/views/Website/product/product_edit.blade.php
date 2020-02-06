@extends('Website.layouts.app')

@section('title', 'Product Management')
@section('meta_description', 'Online Rental Application')
@section('meta_author', 'Rentrotree')

@push('header_styles')

    
@endpush   

@push('header_script')
@endpush

@section('heading')
<h1>
    Update Product <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ url('/product') }}">Product</a></li>
    <li><a href="#">Update Product</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Update Product</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- /.box-header -->
        <div class="box-body">

            <form method="POST" action="{{url('product/update')}}/{{ $product_record->id }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group col-md-6">
                    <label for="">Select Category</label>  <span style="color:red"> *</span>
                    <select id="category_id" name="category_id" class="form-control">
                        <option value="">Select Category</option>
                        @foreach ($category as $key=>$val)
                            <option <?php if($product_record->category_id == $val->id){ echo "Selected"; } ?> value="{{ $val->id }}">{{ $val->category_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="">Select Subcategory</label>  <span style="color:red"> *</span>
                    <select id="subcategory_id" name="subcategory_id" class="form-control">
                        @foreach ($subcategory as $key=>$val)
                            <option <?php if($product_record->subcategory_id == $val->id){ echo "Selected"; } ?> value="{{ $val->id }}">{{ $val->subcategory_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="">Product Name</label> <span style="color:red"> *</span>
                    <input type="text" name="product_name" required class="form-control" value="{{ $product_record->product_name }}" placeholder="Product Name">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Product Brand Name</label> <span style="color:red"> *</span>
                    <input type="text" name="brand" required class="form-control" value="{{ $product_record->brand }}" placeholder="Product Brand Name">
                </div>
                <div class="form-group col-md-3">
                    <label for="">Product Purchase Cost</label> <span style="color:red"> *</span>
                    <input type="text" name="purchase_cost" required class="form-control" value="{{ $product_record->purchase_cost }}" placeholder="Product Purchase Cost">
                </div>
                <div class="form-group col-md-3">
                    <label for="">Product Purchase Date</label> <span style="color:red"> *</span>
                    <input type="date" name="purchase_date" required class="form-control" value="{{ $product_record->purchase_date }}" placeholder="Product Purchase Date">
                </div>
                <div class="form-group col-md-3">
                    <label for="">Product MRP</label> <span style="color:red"> *</span>
                    <input type="text" name="mrp" required class="form-control" value="{{ $product_record->mrp }}" placeholder="Product MRP">
                </div>
                <div class="form-group col-md-3">
                    <label for="">Product Rate</label> <span style="color:red"> *</span>
                    <input type="text" name="rate" required class="form-control" value="{{ $product_record->rate }}" placeholder="Product Rate">
                </div>

                <div class="form-group col-md-3">
                    <label for="">Product Size</label> <span style="color:red"> *</span>
                    <input type="text" name="size" required class="form-control" value="{{ $product_record->size }}" placeholder="Product Size">
                </div>

                <div class="form-group col-md-3">
                    <label for="">Product Color</label> <span style="color:red"> *</span>
                    <input type="text" name="color" required class="form-control" value="{{ $product_record->color }}" placeholder="Product Color">
                </div>

                <div class="form-group col-md-3">
                    <label for="">Product Material</label> <span style="color:red"> *</span>
                    <input type="text" name="material" required class="form-control" value="{{ $product_record->material }}" placeholder="Product Material">
                </div>

                <div class="form-group col-md-3">
                    <label for="">Is featured Product</label> <span style="color:red"> *</span>
                    <select name="featured_status" class="form-control">
                        <option <?php if($product_record->featured_status == 0){ echo "Selected"; } ?> value="0">NO</option>
                        <option <?php if($product_record->featured_status == 1){ echo "Selected"; } ?> value="1">YES</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="">Product Description</label> <span style="color:red"> *</span>
                    <textarea name="description" cols="50" rows="5" required class="form-control" placeholder="Product Description"> {{ $product_record->description }} </textarea>
                </div>

                <div class="form-group col-md-6">
                    <label for="">Update status</label>
                    <select name="status" class="form-control">
                        <option <?php if($product_record->status == 1){ echo "Selected"; } ?> value="1">Active</option>
                        <option <?php if($product_record->status == 0){ echo "Selected"; } ?> value="0">Inactive</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="">Add More Product Image</label>
                    <input type="file" name="product_image[]" multiple class="form-control">
                    <span style="color:blue">you can add multiple image with CTRL + SELECT</span>
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
          <h3 class="box-title">Remove Product Image</h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
            <div class="col-md-12">
                
                @foreach ($product_image as $key=>$value)
                  <div class="col-md-4">
                    <img src="{{url('storage/app')}}/{{$value->product_image}}" width="200px" height="200px" alt="Product Image">
                    <a href="{{url('product/remove_image')}}/{{$value->id}}" class="btn btn-block btn-danger btn-xs">Remove Image</a>

                  </div>
                @endforeach

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

<script type="text/javascript">
    $('#category_id').change(function(){
    var categoryID = $(this).val();    
    if(categoryID){
        $.ajax({
           type:"GET",
           url:"{{url('api/get_subcategory_list')}}/"+categoryID,
           success:function(res){               
            if(res){
                $("#subcategory_id").empty();
                $.each(res,function(id,subcategory_name){
                    $("#subcategory_id").append('<option value="'+id+'">'+subcategory_name+'</option>');
                });
           
            }else{
               $("#subcategory_id").empty();
            }
           }
        });
    }else{
        $("#subcategory_id").empty();
    }      
    });
</script>

@endpush 