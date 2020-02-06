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
    Product <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ url('/product') }}">Product</a></li>
    <li><a href="#">View Product detail</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">View Product</h3>
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
                      <td><b>Product Id</b></td>
                      <td>{{ $product_record->productId }}</td>
                    </tr>
                    <tr>
                      <td><b>Product name</b></td>
                      <td>{{ $product_record->productname }}</td>
                    </tr>
                    <tr>
                      <td><b>Created By</b></td>
                      <td>{{ $product_record->productcreatefirstname }} {{ $product_record->productcreatelastname}}</td>
                    </tr>
                    <tr>
                      <td><b>Category name</b></td>
                      <td>{{ $product_record->productcategoryname }}</td>
                    </tr>
                    <tr>
                      <td><b>Subcategory name</b></td>
                      <td>{{ $product_record->productsubcategoryname }}</td>
                    </tr>
                    <tr>
                      <td><b>Brand</b></td>
                      <td>{{ $product_record->productbrand }}</td>
                    </tr>
                    <tr>
                      <td><b>Purchase Cost</b></td>
                      <td>{{ $product_record->productpurchasecost }}</td>
                    </tr>
                    <tr>
                      <td><b>Product MRP</b></td>
                      <td>{{ $product_record->productmrp }}</td>
                    </tr>
                    <tr>
                      <td><b>Product Purchase date</b></td>
                      <td>{{ $product_record->productpurchesdate }}</td>
                    </tr>
                    <tr>
                      <td><b>Product Rate</b></td>
                      <td>{{ $product_record->productrate }}</td>
                    </tr>
                    <tr>
                      <td><b>Product Rating</b></td>
                      <td>{{ $product_record->productrating }}</td>
                    </tr>
                    <tr>
                      <td><b>Product Description</b></td>
                      <td>{{ $product_record->productdescription }}</td>
                    </tr>
                    <tr>
                      <td><b>Product Size</b></td>
                      <td>{{ $product_record->productsize }}</td>
                    </tr>
                    <tr>
                      <td><b>Product Color</b></td>
                      <td>{{ $product_record->productcolor }}</td>
                    </tr>
                    <tr>
                      <td><b>Product Material</b></td>
                      <td>{{ $product_record->productmaterial }}</td>
                    </tr>
                    <tr>
                      <td><b>Product Featured Status</b></td>
                      <td><?php if($product_record->productfeaturedstatus == 1){ echo '<b style="color:green">YES</b>'; }else{ echo '<b style="color:red">No</b>'; } ?></td>
                    </tr>
                    <tr>
                      <td><b>Created date</b></td>
                      <td>{{ $product_record->productcreatedat }}</td>
                    </tr>
                    <tr>
                      <td><b>Updated date</b></td>
                      <td>{{ $product_record->productupdatedat }}</td>
                    </tr>
                    <tr>
                      <td><b>Product status</b></td>
                      <td><?php if($product_record->productstatus == 1){ echo '<b style="color:green">ACTIVE</b>'; }else{ echo '<b style="color:red">INACTIVE</b>'; } ?></td>
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


  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Product Image</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- /.box-header -->
        <div class="box-body">

            <div class="col-md-12">
                
                @foreach ($product_image as $key=>$value)
                  <div class="col-md-4">
                    <img src="{{url('storage/app')}}/{{$value->product_image}}" width="200px" height="200px" alt="Product Image">
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


  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Product Inventory</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- /.box-header -->
        <div class="box-body">

            <div class="col-md-12">
                
                <table class="table table-hover table-bordered">
                    <tr>
                      <th>Shopkeeper</th>
                      <th>Total</th>
                      <th>Lost</th>
                      <th>Damage</th>
                      <th>OnRent</th>
                      <th>Available</th>
                      <th>Created-At</th>
                      <th>Updated-at</th>
                      <th>Status</th>
                    </tr>
                    @foreach ($product_inventory as $key=>$value)
                      <tr>
                          <td><a href="{{url('shopkeeper/display')}}/{{ $value->shopkeeper_id }}">{{ $value->shopkeeperfirstname }} {{ $value->shopkeeperlastname }}</a></td>
                          <td>{{ $value->total_quantity }}</td>
                          <td>{{ $value->lost_quantity }}</td>
                          <td>{{ $value->damage_quantity }}</td>
                          <td>{{ $value->on_rent_quantity }}</td>
                          <td>{{ $value->available_quantity }}</td>
                          <td>{{ $value->created_at }}</td>
                          <td>{{ $value->updated_at }}</td>
                          <td><?php if($value->status == 1){ echo '<b style="color:green">ACTIVE</b>'; }else{ echo '<b style="color:red">INACTIVE</b>'; } ?></td>
                      </tr>
                    @endforeach
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