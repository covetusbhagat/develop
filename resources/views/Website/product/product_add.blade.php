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
    Add Product <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ url('/product') }}">Product</a></li>
    <li><a href="#">Add Product</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Add New Product</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- /.box-header -->
        <div class="box-body">

            <form method="POST" action="{{url('product/store')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group col-md-6">
                    <label for="">Select Category</label>  <span style="color:red"> *</span>
                    <select id="category_id" name="category_id" class="form-control">
                        <option value="">Select Category</option>
                        @foreach ($category_record as $key=>$val)
                            <option value="{{ $val->id }}">{{ $val->category_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="">Select Subcategory</label>  <span style="color:red"> *</span>
                    <select id="subcategory_id"  name="subcategory_id" class="form-control">
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="">Product Name</label> <span style="color:red"> *</span>
                    <input type="text" value="{{ old('product_name') }}" name="product_name" required class="form-control" placeholder="Product Name">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Product Brand Name</label> <span style="color:red"> *</span>
                    <input type="text" value="{{ old('brand') }}" name="brand" required class="form-control" placeholder="Product Brand Name">
                </div>
                <div class="form-group col-md-3">
                    <label for="">Product Purchase Cost</label> <span style="color:red"> *</span>
                    <input type="text" value="{{ old('purchase_cost') }}" name="purchase_cost" required class="form-control" placeholder="Product Purchase Cost">
                </div>
                <div class="form-group col-md-3">
                    <label for="">Product Purchase Date</label> <span style="color:red"> *</span>
                    <input type="date" value="{{ old('purchase_date') }}" name="purchase_date" required class="form-control" placeholder="Product Purchase Date">
                </div>
                <div class="form-group col-md-3">
                    <label for="">Product MRP</label> <span style="color:red"> *</span>
                    <input type="text" value="{{ old('mrp') }}" name="mrp" required class="form-control" placeholder="Product MRP">
                </div>
                <div class="form-group col-md-3">
                    <label for="">Product Rate</label> <span style="color:red"> *</span>
                    <input type="text" value="{{ old('rate') }}" name="rate" required class="form-control" placeholder="Product Rate">
                </div>

                <div class="form-group col-md-3">
                    <label for="">Product Size</label> <span style="color:red"> *</span>
                    <input type="text" value="{{ old('size') }}" name="size" required class="form-control" placeholder="Product Size">
                </div>

                <div class="form-group col-md-3">
                    <label for="">Product Color</label> <span style="color:red"> *</span>
                    <input type="text" value="{{ old('color') }}" name="color" required class="form-control" placeholder="Product Color">
                </div>

                <div class="form-group col-md-3">
                    <label for="">Product Material</label> <span style="color:red"> *</span>
                    <input type="text" value="{{ old('material') }}" name="material" required class="form-control" placeholder="Product Material">
                </div>

                <div class="form-group col-md-3">
                    <label for="">Is featured Product</label> <span style="color:red"> *</span>
                    <select name="featured_status" class="form-control">
                        <option <?php if(old('material') == 0){ echo "selected";} ?> value="0">NO</option>
                        <option <?php if(old('material') == 1){ echo "selected";} ?> value="1">YES</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="">Product Description</label> <span style="color:red"> *</span>
                    <textarea name="description" value="{{ old('description') }}" cols="50" rows="5" required class="form-control" placeholder="Product Description"> </textarea>
                </div>

                <div class="form-group col-md-6">
                    <label for="">Product Image</label> <span style="color:red"> *</span>
                    <input type="file" name="product_image[]" multiple required class="form-control" placeholder="Product Description">
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